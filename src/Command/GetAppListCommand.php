<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\Symfony\CronJob\Attribute\AsCronTask;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Repository\AccountRepository;
use UmengOpenApiBundle\Repository\AppRepository;
use UmengOpenApiBundle\Service\UmengDataFetcherInterface;

#[AsCronTask(expression: '*/10 * * * *')]
#[AsCommand(name: self::NAME, description: '获取App列表')]
#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'umeng_open_api')]
class GetAppListCommand extends Command
{
    public const NAME = 'umeng-open-api:get-app-list';

    public function __construct(
        private readonly AppRepository $appRepository,
        private readonly AccountRepository $accountRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger,
        private readonly UmengDataFetcherInterface $dataFetcher,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var Account[] $accounts */
        $accounts = $this->accountRepository->findBy(['valid' => true]);
        foreach ($accounts as $account) {
            $startTime = microtime(true);
            $this->logger->info('友盟开放API调用开始', [
                'api' => 'umeng.uapp.getAppList',
                'account_id' => $account->getId(),
                'api_key' => $account->getApiKey(),
                'request_data' => [
                    'page' => 1,
                    'per_page' => 100,
                ],
            ]);

            try {
                $result = $this->dataFetcher->fetchAppList($account, 1, 100);
                $endTime = microtime(true);
                $this->logger->info('友盟开放API调用成功', [
                    'api' => 'umeng.uapp.getAppList',
                    'account_id' => $account->getId(),
                    'duration_ms' => round(($endTime - $startTime) * 1000, 2),
                    'app_count' => (null !== $result->getAppInfos() && is_countable($result->getAppInfos()) ? count($result->getAppInfos()) : 0),
                ]);

                $this->saveAppsToDatabase($account, $result);
            } catch (\Exception $e) {
                $endTime = microtime(true);
                $this->logger->error('友盟开放API调用失败', [
                    'api' => 'umeng.uapp.getAppList',
                    'account_id' => $account->getId(),
                    'duration_ms' => round(($endTime - $startTime) * 1000, 2),
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                throw $e;
            }
        }

        return Command::SUCCESS;
    }

    private function saveAppsToDatabase(Account $account, \UmengUappGetAppListResult $result): void
    {
        $appInfos = $result->getAppInfos();
        if (!is_iterable($appInfos)) {
            return;
        }

        foreach ($appInfos as $appInfo) {
            /** @var \UmengUappAppInfoData $appInfo */
            /** @var App|null $app */
            $app = $this->appRepository->findOneBy([
                'account' => $account,
                'appKey' => $appInfo->getAppkey(),
            ]);
            if (null === $app) {
                $app = new App();
                $app->setAccount($account);
                $app->setAppKey((string) $appInfo->getAppkey());
            }
            $name = $appInfo->getName();
            $app->setName($this->normalizeToString($name));
            $app->setPlatform($this->normalizeToString($appInfo->getPlatform()));
            $app->setPopular((bool) $appInfo->getPopular());
            $app->setUseGameSdk((bool) $appInfo->getUseGameSdk());

            $this->entityManager->persist($app);
            $this->entityManager->flush();
        }
    }

    private function normalizeToString(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        if (null === $value) {
            return '';
        }

        if (is_scalar($value)) {
            return (string) $value;
        }

        return '';
    }
}
