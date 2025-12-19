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
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Tourze\Symfony\CronJob\Attribute\AsCronTask;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\HourlyLaunches;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\HourlyLaunchesRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'umeng_open_api')]
#[AsCronTask(expression: '15 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App启动次数(小时)')]
final class GetHourlyLaunchesCommand extends Command
{
    public const NAME = 'umeng-open-api:get-hourly-launches';

    public function __construct(
        private readonly AppRepository $appRepository,
        private readonly HourlyLaunchesRepository $launchesRepository,
        #[Autowire(service: 'umeng-open-api.property-accessor')] private readonly PropertyAccessor $propertyAccessor,
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
            $this->processAppLaunches($app, $dateRange);
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
    private function processAppLaunches(App $app, array $dateRange): void
    {
        [$startDate, $endDate] = $dateRange;
        $result = $this->dataFetcher->fetchHourlyLaunches($app, $startDate, $endDate);
        $this->saveLaunchesData($app, $result);
    }

    private function saveLaunchesData(App $app, \UmengUappGetLaunchesResult $result): void
    {
        $launchInfo = $result->getLaunchInfo();
        if (!is_iterable($launchInfo)) {
            return;
        }

        foreach ($launchInfo as $item) {
            /** @var \UmengUappCountData $item */
            $date = CarbonImmutable::parse((string) $item->getDate())->startOfDay();

            $dbItem = $this->launchesRepository->findOneBy([
                'app' => $app,
                'date' => $date,
            ]);
            if (null === $dbItem) {
                $dbItem = new HourlyLaunches();
                $dbItem->setApp($app);
                $dbItem->setDate($date);
            }
            /** @var HourlyLaunches $dbItem */
            $this->setHourlyValues($dbItem, $item);
            $this->entityManager->persist($dbItem);
            $this->entityManager->flush();
        }
    }

    private function setHourlyValues(HourlyLaunches $launches, \UmengUappCountData $item): void
    {
        $hourValues = $item->getHourValue();

        if (is_array($hourValues)) {
            foreach ($hourValues as $key => $value) {
                $this->propertyAccessor->setValue($launches, "hour{$key}", $value);
            }
        }
    }
}
