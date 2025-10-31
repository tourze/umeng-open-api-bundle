<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Command;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Attribute\WithMonologChannel;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\Symfony\CronJob\Attribute\AsCronTask;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyData;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\DailyDataRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'umeng_open_api')]
#[AsCronTask(expression: '*/30 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App统计数据')]
class GetDailyDataCommand extends Command
{
    public const NAME = 'umeng-open-api:get-daily-data';

    public function __construct(
        private readonly DailyDataRepository $dailyDataRepository,
        private readonly AppRepository $appRepository,
        private readonly EntityManagerInterface $entityManager,
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

        foreach ($this->appRepository->findAll() as $app) {
            $this->processAppData($app, $dateList);
        }

        return Command::SUCCESS;
    }

    /**
     * @return array<CarbonImmutable>
     */
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

        return array_map(
            fn ($date) => CarbonImmutable::instance($date),
            CarbonPeriod::between($startDate, $endDate)->toArray()
        );
    }

    /**
     * @param array<CarbonImmutable> $dateList
     */
    private function processAppData(App $app, array $dateList): void
    {
        foreach ($dateList as $date) {
            $this->fetchAndSaveDailyData($app, $date);
        }
    }

    private function fetchAndSaveDailyData(App $app, CarbonImmutable $date): void
    {
        $result = $this->dataFetcher->fetchDailyData($app, $date);
        $this->saveDailyData($app, $date, $result);
    }

    private function saveDailyData(App $app, CarbonImmutable $date, \UmengUappGetDailyDataResult $result): void
    {
        $item = $this->dailyDataRepository->findOneBy([
            'app' => $app,
            'date' => $date,
        ]);
        if (null === $item) {
            $item = new DailyData();
            $item->setApp($app);
            $item->setDate($date);
        }
        $dailyData = $result->getDailyData();
        if (null !== $dailyData) {
            $item->setNewUsers($this->normalizeToInt($dailyData->getNewUsers()));
            $item->setTotalUsers($this->normalizeToInt($dailyData->getTotalUsers()));
            $item->setActivityUsers($this->normalizeToInt($dailyData->getActivityUsers()));
            $item->setLaunches($this->normalizeToInt($dailyData->getLaunches()));
            $item->setPayUsers($this->normalizeToInt($dailyData->getPayUsers()));
        } else {
            $item->setNewUsers(0);
            $item->setTotalUsers(0);
            $item->setActivityUsers(0);
            $item->setLaunches(0);
            $item->setPayUsers(0);
        }
        $this->entityManager->persist($item);
        $this->entityManager->flush();
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
}
