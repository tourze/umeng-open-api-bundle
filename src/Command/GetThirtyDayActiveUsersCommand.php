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
use UmengOpenApiBundle\Entity\ThirtyDayActiveUsers;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\ThirtyDayActiveUsersRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'umeng_open_api')]
#[AsCronTask(expression: '*/30 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App活跃用户数(30天)')]
class GetThirtyDayActiveUsersCommand extends Command
{
    public const NAME = 'umeng-open-api:get-thirty-day-active-users';

    public function __construct(
        private readonly AppRepository $appRepository,
        private readonly ThirtyDayActiveUsersRepository $thirtyDaysActiveUsersRepository,
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
            : $endDate->subDays(30);

        return ['startDate' => $startDate, 'endDate' => $endDate];
    }

    private function processApp(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $result = $this->dataFetcher->fetchThirtyDayActiveUsers($app, $startDate, $endDate);
        $this->saveResults($app, $result);
    }

    private function saveResults(App $app, \UmengUappGetActiveUsersResult $result): void
    {
        $activeUserInfo = $result->getActiveUserInfo();
        if (!is_iterable($activeUserInfo)) {
            return;
        }

        foreach ($activeUserInfo as $item) {
            /** @var \UmengUappCountData $item */
            $date = CarbonImmutable::parse((string) $item->getDate())->startOfDay();
            $this->saveActiveUserData($app, $date, $this->normalizeToInt($item->getValue()));
        }
    }

    private function saveActiveUserData(App $app, CarbonImmutable $date, int $value): void
    {
        $newUsers = $this->thirtyDaysActiveUsersRepository->findOneBy([
            'app' => $app,
            'date' => $date,
        ]);

        if (null === $newUsers) {
            $newUsers = new ThirtyDayActiveUsers();
            $newUsers->setApp($app);
            $newUsers->setDate($date);
        }

        $newUsers->setValue($value);
        $this->entityManager->persist($newUsers);
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
