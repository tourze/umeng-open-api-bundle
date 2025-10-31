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
use UmengOpenApiBundle\Entity\DailyDuration;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\DailyDurationRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'umeng_open_api')]
#[AsCronTask(expression: '*/35 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App使用时长-daily')]
class GetDailyDurationCommand extends Command
{
    public const NAME = 'umeng-open-api:get-daily-duration';

    public function __construct(
        private readonly DailyDurationRepository $durationRepository,
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
            $this->processAppDurationData($app, $dateList);
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

        $dates = CarbonPeriod::between($startDate, $endDate)->toArray();

        return array_map(
            fn ($date) => CarbonImmutable::instance($date),
            $dates
        );
    }

    /**
     * @param array<CarbonImmutable> $dateList
     */
    private function processAppDurationData(App $app, array $dateList): void
    {
        foreach ($dateList as $date) {
            $this->processDateDurationData($app, $date);
        }
    }

    private function processDateDurationData(App $app, CarbonImmutable $date): void
    {
        $result = $this->dataFetcher->fetchDurationData($app, $date, 'daily');

        foreach ($result->getDurationInfos() as $durationInfo) {
            $this->saveDurationData($app, $date, $durationInfo);
        }
    }

    private function saveDurationData(App $app, CarbonImmutable $date, \UmengUappDurationInfo $durationInfo): void
    {
        $item = $this->durationRepository->findOneBy([
            'app' => $app,
            'date' => $date,
            'name' => $durationInfo->getName(),
        ]);
        if (null === $item) {
            $item = new DailyDuration();
            $item->setApp($app);
            $item->setDate($date);
            $item->setName((string) $durationInfo->getName());
        }
        $item->setValue($this->normalizeToInt($durationInfo->getValue()));
        $item->setPercent($this->normalizeToFloat($durationInfo->getPercent()));
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
