<?php

namespace UmengOpenApiBundle\Command;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tourze\Symfony\CronJob\Attribute\AsCronTask;
use UmengOpenApiBundle\Entity\Channel;
use UmengOpenApiBundle\Entity\DailyChannelData;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\ChannelRepository;
use UmengOpenApiBundle\Repository\DailyChannelDataRepository;

#[AsCronTask('*/30 * * * *')]
#[AsCommand(name: self::NAME, description: '获取渠道维度统计数据')]
class GetChannelDataCommand extends Command
{
    public const NAME = 'umeng-open-api:get-channel-data';

    public function __construct(
        private readonly AppRepository $appRepository,
        private readonly ChannelRepository $channelRepository,
        private readonly DailyChannelDataRepository $dailyChannelDataRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('startDate', InputArgument::OPTIONAL)
            ->addArgument('endDate', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $endDate = $input->getArgument('endDate') !== null
            ? CarbonImmutable::parse($input->getArgument('endDate'))->startOfDay()
            : CarbonImmutable::today();
        $startDate = $input->getArgument('startDate') !== null
            ? CarbonImmutable::parse($input->getArgument('startDate'))->startOfDay()
            : $endDate->subDays(30);
        $dateList = CarbonPeriod::between($startDate, $endDate)->toArray();

        foreach ($this->appRepository->findAll() as $app) {
            $account = $app->getAccount();

            // 请替换第一个参数apiKey和第二个参数apiSecurity
            $clientPolicy = new \ClientPolicy($account->getApiKey(), $account->getApiSecurity(), 'gateway.open.umeng.com');
            $syncAPIClient = new \SyncAPIClient($clientPolicy);

            $reqPolicy = new \RequestPolicy();
            $reqPolicy->httpMethod = 'POST';
            $reqPolicy->needAuthorization = false;
            $reqPolicy->requestSendTimestamp = false;
            // 测试环境只支持http
            // $reqPolicy->useHttps = false;
            $reqPolicy->useHttps = true;
            $reqPolicy->useSignture = true;
            $reqPolicy->accessPrivateApi = false;

            foreach ($dateList as $date) {
                // --------------------------构造参数----------------------------------
                $param = new \UmengUappGetChannelDataParam();
                $param->setAppkey($app->getAppKey());
                $param->setDate($date->format('Y-m-d'));
                $param->setPerPage(100);
                $param->setPage(1);

                // --------------------------构造请求----------------------------------

                $request = new \APIRequest();
                $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getChannelData', 1);
                $request->apiId = $apiId;
                /** @phpstan-ignore-next-line */
                $request->requestEntity = $param;

                // --------------------------构造结果----------------------------------

                $result = new \UmengUappGetChannelDataResult();
                $syncAPIClient->send($request, $result, $reqPolicy);

                foreach ($result->getChannelInfos() as $item) {
                    /** @var \UmengUappChannelInfo $item */

                    // 先确保渠道存在
                    $channel = $this->channelRepository->findOneBy(['code' => (string) $item->getId()]);
                    if ($channel === null) {
                        $channel = new Channel();
                        $channel->setCode((string) $item->getId());
                    }
                    $channel->setApp($app);
                    $channel->setName((string) $item->getChannel());
                    $this->entityManager->persist($channel);
                    $this->entityManager->flush();

                    $dailyData = $this->dailyChannelDataRepository->findOneBy([
                        'channel' => $channel,
                        'date' => $date,
                    ]);
                    if ($dailyData === null) {
                        $dailyData = new DailyChannelData();
                        $dailyData->setChannel($channel);
                        $dailyData->setDate($date);
                    }
                    $dailyData->setLaunch((int) $item->getLaunch());
                    $dailyData->setDuration(self::convertTimeToSecond((string) $item->getDuration()));
                    $dailyData->setTotalUserRate((float) $item->getTotalUserRate());
                    $dailyData->setActiveUser((int) $item->getActiveUser());
                    $dailyData->setNewUser((int) $item->getNewUser());
                    $dailyData->setTotalUser((int) $item->getTotalUser());
                    $this->entityManager->persist($dailyData);
                    $this->entityManager->flush();
                }
            }
        }

        return Command::SUCCESS;
    }

    private static function convertTimeToSecond(string $time): string
    {
        $d = explode(':', $time);

        return (string) ((intval($d[0]) * 3600) + (intval($d[1]) * 60) + intval($d[2]));
    }
}
