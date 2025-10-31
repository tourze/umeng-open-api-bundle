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
use UmengOpenApiBundle\Entity\HourlyNewUsers;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\HourlyNewUsersRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'umeng_open_api')]
#[AsCronTask(expression: '15 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App新增用户数(小时)')]
class GetHourlyNewUsersCommand extends Command
{
    public const NAME = 'umeng-open-api:get-hourly-new-users';

    public function __construct(
        private readonly AppRepository $appRepository,
        private readonly HourlyNewUsersRepository $newUsersRepository,
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
            $this->processAppNewUsers($app, $dateRange);
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
    private function processAppNewUsers(App $app, array $dateRange): void
    {
        [$startDate, $endDate] = $dateRange;
        $result = $this->dataFetcher->fetchHourlyNewUsers($app, $startDate, $endDate);
        $this->saveNewUsersData($app, $result);
    }

    private function saveNewUsersData(App $app, \UmengUappGetNewUsersResult $result): void
    {
        $newUserInfo = $result->getNewUserInfo();
        if (!is_iterable($newUserInfo)) {
            return;
        }

        foreach ($newUserInfo as $item) {
            /** @var \UmengUappCountData $item */
            $date = CarbonImmutable::parse((string) $item->getDate())->startOfDay();

            $dbItem = $this->newUsersRepository->findOneBy([
                'app' => $app,
                'date' => $date,
            ]);
            if (null === $dbItem) {
                $dbItem = new HourlyNewUsers();
                $dbItem->setApp($app);
                $dbItem->setDate($date);
            }
            /** @var HourlyNewUsers $dbItem */
            $this->setHourlyValues($dbItem, $item);
            $this->entityManager->persist($dbItem);
            $this->entityManager->flush();
        }
    }

    private function setHourlyValues(HourlyNewUsers $newUsers, \UmengUappCountData $item): void
    {
        $hourValues = $item->getHourValue();

        if (is_array($hourValues)) {
            foreach ($hourValues as $key => $value) {
                $this->propertyAccessor->setValue($newUsers, "hour{$key}", $value);
            }
        }
    }
}
