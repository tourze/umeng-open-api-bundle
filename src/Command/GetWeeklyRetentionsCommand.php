<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Command;

use Carbon\CarbonImmutable;
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
use UmengOpenApiBundle\Entity\WeeklyRetentions;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\WeeklyRetentionsRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'umeng_open_api')]
#[AsCronTask(expression: '*/30 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App新增用户留存率(周)')]
final class GetWeeklyRetentionsCommand extends Command
{
    public const NAME = 'umeng-open-api:get-weekly-retentions';

    public function __construct(
        private readonly AppRepository $appRepository,
        private readonly WeeklyRetentionsRepository $retentionsRepository,
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
            /** @var App $app */
            $this->processApp($app, $dateRange['startDate'], $dateRange['endDate']);
        }

        return Command::SUCCESS;
    }

    /**
     * @return array{startDate: CarbonImmutable, endDate: CarbonImmutable}
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
            : $endDate->subDays(180);

        return ['startDate' => $startDate, 'endDate' => $endDate];
    }

    private function processApp(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $result = $this->dataFetcher->fetchWeeklyRetentions($app, $startDate, $endDate);
        $this->saveResults($app, $result);
    }

    private function saveResults(App $app, \UmengUappGetRetentionsResult $result): void
    {
        $retentionInfo = $result->getRetentionInfo();
        if (!is_iterable($retentionInfo)) {
            return;
        }

        foreach ($retentionInfo as $item) {
            /** @var \UmengUappRetentionInfo $item */
            $date = CarbonImmutable::parse((string) $item->getDate())->startOfDay();
            $this->saveRetentionData($app, $date, $item);
        }
    }

    private function saveRetentionData(App $app, CarbonImmutable $date, \UmengUappRetentionInfo $item): void
    {
        $retention = $this->retentionsRepository->findOneBy([
            'app' => $app,
            'date' => $date,
        ]);

        if (null === $retention) {
            $retention = new WeeklyRetentions();
            $retention->setApp($app);
            $retention->setDate($date);
        }

        $retention->setTotalInstallUser($this->normalizeToInt($item->getTotalInstallUser()));
        $retention->setRetentionRate($this->normalizeToFloat($item->getRetentionRate()));
        $this->entityManager->persist($retention);
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
}
