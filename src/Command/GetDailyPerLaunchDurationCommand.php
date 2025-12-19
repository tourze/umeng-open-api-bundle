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
use UmengOpenApiBundle\Entity\DailyPerLaunchDuration;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\DailyPerLaunchDurationRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'umeng_open_api')]
#[AsCronTask(expression: '*/35 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App使用时长-daily_per_launch')]
final class GetDailyPerLaunchDurationCommand extends Command
{
    public const NAME = 'umeng-open-api:get-daily-per-launch-duration';

    public function __construct(
        private readonly DailyPerLaunchDurationRepository $durationRepository,
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
            $this->processAppWithDates($app, $dateList);
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
    private function processAppWithDates(App $app, array $dateList): void
    {
        foreach ($dateList as $date) {
            $this->processSingleDate($app, $date);
        }
    }

    private function processSingleDate(App $app, CarbonImmutable $date): void
    {
        $result = $this->dataFetcher->fetchDurationData($app, $date, 'daily_per_launch');
        $this->processResultData($app, $date, $result);
    }

    private function processResultData(App $app, CarbonImmutable $date, \UmengUappGetDurationsResult $result): void
    {
        $durationInfos = $result->getDurationInfos();
        if (!is_iterable($durationInfos)) {
            return;
        }

        foreach ($durationInfos as $durationInfo) {
            $item = $this->durationRepository->findOneBy([
                'app' => $app,
                'date' => $date,
                'name' => $durationInfo->getName(),
            ]);

            if (null === $item) {
                $item = new DailyPerLaunchDuration();
                $item->setApp($app);
                $item->setDate($date);
                $item->setName((string) $durationInfo->getName());
            }

            $item->setValue($this->normalizeToInt($durationInfo->getValue()));
            $item->setPercent($this->normalizeToFloat($durationInfo->getPercent()));
            $this->entityManager->persist($item);
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
