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
use UmengOpenApiBundle\Entity\SevenDaysLaunches;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\SevenDaysLaunchesRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'umeng_open_api')]
#[AsCronTask(expression: '*/30 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App启动次数(7天)')]
class GetSevenDayLaunchesCommand extends Command
{
    public const NAME = 'umeng-open-api:get-seven-day-launches';

    public function __construct(
        private readonly AppRepository $appRepository,
        private readonly SevenDaysLaunchesRepository $sevenDaysLaunchesRepository,
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
            : $endDate->subDays(7);

        return ['startDate' => $startDate, 'endDate' => $endDate];
    }

    private function processApp(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $result = $this->dataFetcher->fetchSevenDayLaunches($app, $startDate, $endDate);
        $this->saveResults($app, $result);
    }

    private function saveResults(App $app, \UmengUappGetLaunchesResult $result): void
    {
        $launchInfo = $result->getLaunchInfo();
        if (!is_iterable($launchInfo)) {
            return;
        }

        foreach ($launchInfo as $item) {
            /** @var \UmengUappCountData $item */
            $date = CarbonImmutable::parse((string) $item->getDate())->startOfDay();
            $this->saveLaunchData($app, $date, (int) $item->getValue());
        }
    }

    private function saveLaunchData(App $app, CarbonImmutable $date, int $value): void
    {
        $launches = $this->sevenDaysLaunchesRepository->findOneBy([
            'app' => $app,
            'date' => $date,
        ]);

        if (null === $launches) {
            $launches = new SevenDaysLaunches();
            $launches->setApp($app);
            $launches->setDate($date);
        }

        $launches->setValue($value);
        $this->entityManager->persist($launches);
        $this->entityManager->flush();
    }
}
