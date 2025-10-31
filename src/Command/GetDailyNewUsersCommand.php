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
use UmengOpenApiBundle\Entity\DailyNewUsers;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Repository\DailyNewUsersRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'umeng_open_api')]
#[AsCronTask(expression: '*/30 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App新增用户数(天)')]
class GetDailyNewUsersCommand extends Command
{
    public const NAME = 'umeng-open-api:get-daily-new-users';

    public function __construct(
        private readonly AppRepository $appRepository,
        private readonly DailyNewUsersRepository $newUsersRepository,
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
        $result = $this->dataFetcher->fetchDailyNewUsers($app, $startDate, $endDate);
        $this->processResultData($app, $result);
    }

    private function processResultData(App $app, \UmengUappGetNewUsersResult $result): void
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
                $dbItem = new DailyNewUsers();
                $dbItem->setApp($app);
                $dbItem->setDate($date);
            }

            $dbItem->setValue($this->normalizeToInt($item->getValue()));
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
