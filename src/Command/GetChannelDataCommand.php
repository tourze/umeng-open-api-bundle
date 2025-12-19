<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Command;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\Symfony\CronJob\Attribute\AsCronTask;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\Channel;
use UmengOpenApiBundle\Entity\DailyChannelData;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\ChannelRepository;
use UmengOpenApiBundle\Repository\DailyChannelDataRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

#[AsCronTask(expression: '*/30 * * * *')]
#[AsCommand(name: self::NAME, description: '获取渠道维度统计数据')]
#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'umeng_open_api')]
final class GetChannelDataCommand extends Command
{
    public const NAME = 'umeng-open-api:get-channel-data';

    public function __construct(
        private readonly AppRepository $appRepository,
        private readonly ChannelRepository $channelRepository,
        private readonly DailyChannelDataRepository $dailyChannelDataRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger,
        private readonly UmengDataFetcherInterface $dataFetcher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('startDate', InputArgument::OPTIONAL)
            ->addArgument('endDate', InputArgument::OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dateList = $this->parseDateRange($input);

        /** @var App[] $apps */
        $apps = $this->appRepository->findAll();
        foreach ($apps as $app) {
            $this->processAppChannelData($app, $dateList);
        }

        return Command::SUCCESS;
    }

    /** @return array<CarbonImmutable> */
    private function parseDateRange(InputInterface $input): array
    {
        $endDateArg = $input->getArgument('endDate');
        $endDate = null !== $endDateArg && is_string($endDateArg)
            ? CarbonImmutable::parse($endDateArg)->startOfDay()
            : CarbonImmutable::today();
        $startDateArg = $input->getArgument('startDate');
        $startDate = null !== $startDateArg && is_string($startDateArg)
            ? CarbonImmutable::parse($startDateArg)->startOfDay()
            : $endDate->subDays(30);

        /** @var CarbonImmutable[] $dates */
        $dates = [];
        $period = CarbonPeriod::between($startDate, $endDate);

        // Convert CarbonPeriod to array to avoid PHPStan iteration error
        $dateArray = $period->toArray();
        foreach ($dateArray as $date) {
            if ($date instanceof CarbonImmutable) {
                $dates[] = $date;
            } else {
                // CarbonPeriod items are always CarbonInterface instances
                $dates[] = $date->toImmutable();
            }
        }

        return $dates;
    }

    /** @param array<CarbonImmutable> $dateList */
    private function processAppChannelData(App $app, array $dateList): void
    {
        foreach ($dateList as $date) {
            $this->processDateChannelData($app, $date);
        }
    }

    private function processDateChannelData(App $app, CarbonImmutable $date): void
    {
        $startTime = microtime(true);
        $this->logger->info('友盟开放API调用开始', [
            'api' => 'umeng.uapp.getChannelData',
            'app_key' => $app->getAppKey(),
            'date' => $date->format('Y-m-d'),
            'request_data' => [
                'appkey' => $app->getAppKey(),
                'date' => $date->format('Y-m-d'),
                'per_page' => 100,
                'page' => 1,
            ],
        ]);

        try {
            $result = $this->dataFetcher->fetchChannelData($app, $date, 1, 100);
            $endTime = microtime(true);
            $this->logger->info('友盟开放API调用成功', [
                'api' => 'umeng.uapp.getChannelData',
                'app_key' => $app->getAppKey(),
                'date' => $date->format('Y-m-d'),
                'duration_ms' => round(($endTime - $startTime) * 1000, 2),
                'channel_count' => (null !== $result->getChannelInfos() && is_countable($result->getChannelInfos()) ? count($result->getChannelInfos()) : 0),
            ]);

            $channelInfos = $result->getChannelInfos();
            if (is_iterable($channelInfos)) {
                foreach ($channelInfos as $item) {
                    if ($item instanceof \UmengUappChannelInfo) {
                        $this->saveChannelData($app, $date, $item);
                    }
                }
            }
        } catch (\Exception $e) {
            $endTime = microtime(true);
            $this->logger->error('友盟开放API调用失败', [
                'api' => 'umeng.uapp.getChannelData',
                'app_key' => $app->getAppKey(),
                'date' => $date->format('Y-m-d'),
                'duration_ms' => round(($endTime - $startTime) * 1000, 2),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    private function saveChannelData(App $app, CarbonImmutable $date, \UmengUappChannelInfo $item): void
    {
        $channel = $this->ensureChannelExists($app, $item);
        $this->saveDailyChannelData($channel, $date, $item);
    }

    private function ensureChannelExists(App $app, \UmengUappChannelInfo $item): Channel
    {
        /** @var Channel|null $channel */
        $channel = $this->channelRepository->findOneBy(['code' => (string) $item->getId()]);
        if (null === $channel) {
            $channel = new Channel();
            $channel->setCode((string) $item->getId());
        }
        $channel->setApp($app);
        $channelName = $item->getChannel();
        $channel->setName(is_string($channelName) ? $channelName : '');
        $this->entityManager->persist($channel);
        $this->entityManager->flush();

        return $channel;
    }

    private function saveDailyChannelData(Channel $channel, CarbonImmutable $date, \UmengUappChannelInfo $item): void
    {
        $dailyData = $this->findOrCreateDailyChannelData($channel, $date);
        $this->updateDailyChannelDataFields($dailyData, $item);
        $this->entityManager->persist($dailyData);
        $this->entityManager->flush();
    }

    private function findOrCreateDailyChannelData(Channel $channel, CarbonImmutable $date): DailyChannelData
    {
        /** @var DailyChannelData|null $dailyData */
        $dailyData = $this->dailyChannelDataRepository->findOneBy([
            'channel' => $channel,
            'date' => $date,
        ]);

        if (null === $dailyData) {
            $dailyData = new DailyChannelData();
            $dailyData->setChannel($channel);
            $dailyData->setDate($date);
        }

        return $dailyData;
    }

    private function updateDailyChannelDataFields(DailyChannelData $dailyData, \UmengUappChannelInfo $item): void
    {
        $dailyData->setLaunch($this->normalizeToInt($item->getLaunch()));
        $dailyData->setDuration(self::convertTimeToSecond($this->normalizeToString($item->getDuration(), '0:0:0')));
        $dailyData->setTotalUserRate($this->normalizeToFloat($item->getTotalUserRate()));
        $dailyData->setActiveUser($this->normalizeToInt($item->getActiveUser()));
        $dailyData->setNewUser($this->normalizeToInt($item->getNewUser()));
        $dailyData->setTotalUser($this->normalizeToInt($item->getTotalUser()));
    }

    private function normalizeToInt(mixed $value): int
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        return 0;
    }

    private function normalizeToFloat(mixed $value): float
    {
        if (is_float($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        return 0.0;
    }

    private function normalizeToString(mixed $value, string $default): string
    {
        if (is_string($value)) {
            return $value;
        }

        return $default;
    }

    private static function convertTimeToSecond(string $time): string
    {
        $d = explode(':', $time);

        return (string) ((intval($d[0]) * 3600) + (intval($d[1]) * 60) + intval($d[2]));
    }
}
