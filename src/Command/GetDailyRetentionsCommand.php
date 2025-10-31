<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Command;

use Carbon\CarbonImmutable;
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
use UmengOpenApiBundle\Entity\DailyRetentions;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\DailyRetentionsRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'umeng_open_api')]
#[AsCronTask(expression: '*/30 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App新增用户留存率(天)')]
class GetDailyRetentionsCommand extends Command
{
    public const NAME = 'umeng-open-api:get-daily-retentions';

    public function __construct(
        private readonly AppRepository $appRepository,
        private readonly DailyRetentionsRepository $retentionsRepository,
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
        $dateRange = $this->parseDateRange($input);

        foreach ($this->appRepository->findAll() as $app) {
            $this->processApp($app, $dateRange);
        }

        return Command::SUCCESS;
    }

    /**
     * @return array{CarbonImmutable, CarbonImmutable}
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

        return [$startDate, $endDate];
    }

    /**
     * @param array{CarbonImmutable, CarbonImmutable} $dateRange
     */
    private function processApp(App $app, array $dateRange): void
    {
        [$startDate, $endDate] = $dateRange;
        $result = $this->dataFetcher->fetchDailyRetentions($app, $startDate, $endDate);
        $this->processResultData($app, $result);
    }

    private function processResultData(App $app, \UmengUappGetRetentionsResult $result): void
    {
        $retentionInfo = $result->getRetentionInfo();
        if (!is_iterable($retentionInfo)) {
            return;
        }

        foreach ($retentionInfo as $item) {
            /** @var \UmengUappRetentionInfo $item */
            $date = CarbonImmutable::parse((string) $item->getDate())->startOfDay();

            $dbItem = $this->retentionsRepository->findOneBy([
                'app' => $app,
                'date' => $date,
            ]);

            if (null === $dbItem) {
                $dbItem = new DailyRetentions();
                $dbItem->setApp($app);
                $dbItem->setDate($date);
            }

            $dbItem->setTotalInstallUser($this->normalizeToInt($item->getTotalInstallUser()));
            $retentionData = $item->getRetentionRate();
            if (is_array($retentionData)) {
                $formattedRetention = [];
                $days = [1, 2, 3, 4, 5, 6, 7, 14, 30];
                foreach ($retentionData as $index => $rate) {
                    $day = $days[$index] ?? ($index + 1);
                    $formattedRetention["day_{$day}"] = $rate;
                }
                $dbItem->setRetentionRate($formattedRetention);
            } elseif (null !== $retentionData) {
                $dbItem->setRetentionRate(['total' => $retentionData]);
            }
            $this->entityManager->persist($dbItem);
            $this->entityManager->flush();
        }
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
