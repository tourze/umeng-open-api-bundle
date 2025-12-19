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
use UmengOpenApiBundle\Entity\HourlyActiveUsers;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\HourlyActiveUsersRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'umeng_open_api')]
#[AsCronTask(expression: '*/30 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App活跃用户数(小时)')]
final class GetHourlyActiveUsersCommand extends Command
{
    public const NAME = 'umeng-open-api:get-hourly-active-users';

    public function __construct(
        private readonly AppRepository $appRepository,
        private readonly HourlyActiveUsersRepository $activeUsersRepository,
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
            $this->processAppActiveUsers($app, $dateRange);
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
    private function processAppActiveUsers(App $app, array $dateRange): void
    {
        [$startDate, $endDate] = $dateRange;
        $result = $this->dataFetcher->fetchHourlyActiveUsers($app, $startDate, $endDate);
        $this->saveActiveUsersData($app, $result);
    }

    private function saveActiveUsersData(App $app, \UmengUappGetActiveUsersResult $result): void
    {
        $activeUserInfo = $result->getActiveUserInfo();
        if (!is_iterable($activeUserInfo)) {
            return;
        }

        foreach ($activeUserInfo as $item) {
            /** @var \UmengUappCountData $item */
            $date = CarbonImmutable::parse((string) $item->getDate())->startOfDay();

            $dbItem = $this->activeUsersRepository->findOneBy([
                'app' => $app,
                'date' => $date,
            ]);
            if (null === $dbItem) {
                $dbItem = new HourlyActiveUsers();
                $dbItem->setApp($app);
                $dbItem->setDate($date);
            }
            /** @var HourlyActiveUsers $dbItem */
            $this->setHourlyValues($dbItem, $item);
            $this->entityManager->persist($dbItem);
            $this->entityManager->flush();
        }
    }

    private function setHourlyValues(HourlyActiveUsers $activeUsers, \UmengUappCountData $item): void
    {
        $hourValues = $item->getHourValue();

        if (is_array($hourValues)) {
            foreach ($hourValues as $key => $value) {
                $this->propertyAccessor->setValue($activeUsers, "hour{$key}", $value);
            }
        }
    }
}
