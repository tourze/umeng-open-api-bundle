<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Service;

use Carbon\CarbonImmutable;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Exception\InvalidAppException;

#[WithMonologChannel(channel: 'umeng_open_api')]
readonly class UmengDataFetcher implements UmengDataFetcherInterface
{
    public function __construct(
        private UmengApiClientFactory $clientFactory,
        private LoggerInterface $logger,
    ) {
    }

    public function fetchDailyLaunches(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetLaunchesResult
    {
        $account = $app->getAccount();
        if (null === $account) {
            throw new InvalidAppException('App must have an associated account');
        }

        $syncApiClient = $this->clientFactory->createClient($account);
        $reqPolicy = $this->clientFactory->createRequestPolicy();
        $request = $this->createLaunchesRequest($app, $startDate, $endDate);
        $result = new \UmengUappGetLaunchesResult();

        $this->logApiStart($app, $startDate, $endDate);
        $apiStartTime = microtime(true);

        try {
            $this->logger->info('友盟API审计日志：外部系统交互开始', [
                'action' => 'SyncAPIClient::send()',
                'api' => 'umeng.uapp.getLaunches',
                'app_key' => $app->getAppKey(),
                'request_params' => [
                    'appkey' => $app->getAppKey(),
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                ],
                'timestamp' => date('Y-m-d H:i:s'),
                'request_id' => $requestId = uniqid('umeng_', true),
            ]);

            $syncApiClient->send($request, $result, $reqPolicy);

            $endTime = microtime(true);
            $this->logger->info('友盟API审计日志：外部系统交互成功', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId,
                'duration_ms' => round(($endTime - $apiStartTime) * 1000, 2),
                'response_count' => null !== $result->getLaunchInfo() && (is_array($result->getLaunchInfo()) || $result->getLaunchInfo() instanceof \Countable) ? count($result->getLaunchInfo()) : 0,
            ]);

            $this->logApiSuccess($app, $apiStartTime, $result);
        } catch (\Exception $e) {
            $this->logger->error('友盟API审计日志：外部系统交互异常', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId ?? 'unknown',
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'duration_ms' => round((microtime(true) - $apiStartTime) * 1000, 2),
            ]);

            $this->logApiError($app, $apiStartTime, $e);
            throw $e;
        }

        return $result;
    }

    public function fetchAppList(Account $account, int $page = 1, int $perPage = 100): \UmengUappGetAppListResult
    {
        $syncApiClient = $this->clientFactory->createClient($account);
        $reqPolicy = $this->clientFactory->createRequestPolicy();
        $request = $this->createAppListRequest($page, $perPage);
        $result = new \UmengUappGetAppListResult();

        $this->logAppListApiStart($account, $page, $perPage);
        $apiStartTime = microtime(true);

        try {
            $requestId = uniqid('umeng_', true);
            $this->logger->info('友盟API审计日志：外部系统交互开始', [
                'action' => 'SyncAPIClient::send()',
                'api' => 'umeng.uapp.getAppList',
                'account_id' => $account->getId(),
                'request_params' => [
                    'page' => $page,
                    'per_page' => $perPage,
                ],
                'timestamp' => date('Y-m-d H:i:s'),
                'request_id' => $requestId,
            ]);

            $syncApiClient->send($request, $result, $reqPolicy);

            $endTime = microtime(true);
            $this->logger->info('友盟API审计日志：外部系统交互成功', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId,
                'duration_ms' => round(($endTime - $apiStartTime) * 1000, 2),
                'response_count' => null !== $result->getAppInfos() && (is_array($result->getAppInfos()) || $result->getAppInfos() instanceof \Countable) ? count($result->getAppInfos()) : 0,
            ]);

            $this->logAppListApiSuccess($account, $apiStartTime, $result);
        } catch (\Exception $e) {
            $this->logger->error('友盟API审计日志：外部系统交互异常', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId ?? 'unknown',
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'duration_ms' => round((microtime(true) - $apiStartTime) * 1000, 2),
            ]);

            $this->logAppListApiError($account, $apiStartTime, $e);
            throw $e;
        }

        return $result;
    }

    public function fetchHourlyLaunches(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetLaunchesResult
    {
        return $this->fetchLaunchesWithPeriodType($app, $startDate, $endDate, 'hourly');
    }

    public function fetchWeeklyLaunches(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetLaunchesResult
    {
        return $this->fetchLaunchesWithPeriodType($app, $startDate, $endDate, 'weekly');
    }

    public function fetchMonthlyLaunches(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetLaunchesResult
    {
        return $this->fetchLaunchesWithPeriodType($app, $startDate, $endDate, 'monthly');
    }

    public function fetchSevenDayLaunches(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetLaunchesResult
    {
        return $this->fetchLaunchesWithPeriodType($app, $startDate, $endDate, '7day');
    }

    public function fetchThirtyDayLaunches(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetLaunchesResult
    {
        return $this->fetchLaunchesWithPeriodType($app, $startDate, $endDate, '30day');
    }

    public function fetchDailyActiveUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetActiveUsersResult
    {
        return $this->fetchActiveUsersWithPeriodType($app, $startDate, $endDate, 'daily');
    }

    public function fetchHourlyActiveUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetActiveUsersResult
    {
        return $this->fetchActiveUsersWithPeriodType($app, $startDate, $endDate, 'hourly');
    }

    public function fetchWeeklyActiveUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetActiveUsersResult
    {
        return $this->fetchActiveUsersWithPeriodType($app, $startDate, $endDate, 'weekly');
    }

    public function fetchMonthlyActiveUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetActiveUsersResult
    {
        return $this->fetchActiveUsersWithPeriodType($app, $startDate, $endDate, 'monthly');
    }

    public function fetchSevenDaysActiveUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetActiveUsersResult
    {
        return $this->fetchActiveUsersWithPeriodType($app, $startDate, $endDate, '7day');
    }

    public function fetchThirtyDayActiveUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetActiveUsersResult
    {
        return $this->fetchActiveUsersWithPeriodType($app, $startDate, $endDate, '30day');
    }

    public function fetchDailyNewUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetNewUsersResult
    {
        return $this->fetchNewUsersWithPeriodType($app, $startDate, $endDate, 'daily');
    }

    public function fetchHourlyNewUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetNewUsersResult
    {
        return $this->fetchNewUsersWithPeriodType($app, $startDate, $endDate, 'hourly');
    }

    public function fetchWeeklyNewUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetNewUsersResult
    {
        return $this->fetchNewUsersWithPeriodType($app, $startDate, $endDate, 'weekly');
    }

    public function fetchMonthlyNewUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetNewUsersResult
    {
        return $this->fetchNewUsersWithPeriodType($app, $startDate, $endDate, 'monthly');
    }

    public function fetchSevenDayNewUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetNewUsersResult
    {
        return $this->fetchNewUsersWithPeriodType($app, $startDate, $endDate, '7day');
    }

    public function fetchThirtyDayNewUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetNewUsersResult
    {
        return $this->fetchNewUsersWithPeriodType($app, $startDate, $endDate, '30day');
    }

    public function fetchDailyRetentions(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetRetentionsResult
    {
        return $this->fetchRetentionsWithPeriodType($app, $startDate, $endDate, 'daily');
    }

    public function fetchWeeklyRetentions(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetRetentionsResult
    {
        return $this->fetchRetentionsWithPeriodType($app, $startDate, $endDate, 'weekly');
    }

    public function fetchMonthlyRetentions(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetRetentionsResult
    {
        return $this->fetchRetentionsWithPeriodType($app, $startDate, $endDate, 'monthly');
    }

    public function fetchDurationData(App $app, CarbonImmutable $date, string $statType, string $version = '', string $channel = ''): \UmengUappGetDurationsResult
    {
        $account = $app->getAccount();
        if (null === $account) {
            throw new InvalidAppException('App must have an associated account');
        }

        $syncApiClient = $this->clientFactory->createClient($account);
        $reqPolicy = $this->clientFactory->createRequestPolicy();
        $request = $this->createDurationRequest($app, $date, $statType, $version, $channel);
        $result = new \UmengUappGetDurationsResult();

        $this->logDurationApiStart($app, $date, $statType);
        $apiStartTime = microtime(true);

        try {
            $requestId = uniqid('umeng_', true);
            $this->logger->info('友盟API审计日志：外部系统交互开始', [
                'action' => 'SyncAPIClient::send()',
                'api' => 'umeng.uapp.getDurations',
                'app_key' => $app->getAppKey(),
                'request_params' => [
                    'appkey' => $app->getAppKey(),
                    'date' => $date->format('Y-m-d'),
                    'stat_type' => $statType,
                    'version' => $version,
                    'channel' => $channel,
                ],
                'timestamp' => date('Y-m-d H:i:s'),
                'request_id' => $requestId,
            ]);

            $syncApiClient->send($request, $result, $reqPolicy);

            $endTime = microtime(true);
            $this->logger->info('友盟API审计日志：外部系统交互成功', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId,
                'duration_ms' => round(($endTime - $apiStartTime) * 1000, 2),
                'response_count' => null !== $result->getDurationInfos() && (is_array($result->getDurationInfos()) || $result->getDurationInfos() instanceof \Countable) ? count($result->getDurationInfos()) : 0,
            ]);

            $this->logDurationApiSuccess($app, $apiStartTime, $result, $date, $statType);
        } catch (\Exception $e) {
            $this->logger->error('友盟API审计日志：外部系统交互异常', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId ?? 'unknown',
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'duration_ms' => round((microtime(true) - $apiStartTime) * 1000, 2),
            ]);

            $this->logDurationApiError($app, $apiStartTime, $e, $date, $statType);
            throw $e;
        }

        return $result;
    }

    public function fetchChannelData(App $app, CarbonImmutable $date, int $page = 1, int $perPage = 100): \UmengUappGetChannelDataResult
    {
        $account = $app->getAccount();
        if (null === $account) {
            throw new InvalidAppException('App must have an associated account');
        }

        $syncApiClient = $this->clientFactory->createClient($account);
        $reqPolicy = $this->clientFactory->createRequestPolicy();
        $request = $this->createChannelDataRequest($app, $date, $page, $perPage);
        $result = new \UmengUappGetChannelDataResult();

        $this->logChannelDataApiStart($app, $date, $page, $perPage);
        $apiStartTime = microtime(true);

        try {
            $requestId = uniqid('umeng_', true);
            $this->logger->info('友盟API审计日志：外部系统交互开始', [
                'action' => 'SyncAPIClient::send()',
                'api' => 'umeng.uapp.getChannelData',
                'app_key' => $app->getAppKey(),
                'request_params' => [
                    'appkey' => $app->getAppKey(),
                    'date' => $date->format('Y-m-d'),
                    'page' => $page,
                    'per_page' => $perPage,
                ],
                'timestamp' => date('Y-m-d H:i:s'),
                'request_id' => $requestId,
            ]);

            $syncApiClient->send($request, $result, $reqPolicy);

            $endTime = microtime(true);
            $this->logger->info('友盟API审计日志：外部系统交互成功', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId,
                'duration_ms' => round(($endTime - $apiStartTime) * 1000, 2),
                'response_count' => null !== $result->getChannelInfos() && (is_array($result->getChannelInfos()) || $result->getChannelInfos() instanceof \Countable) ? count($result->getChannelInfos()) : 0,
            ]);

            $this->logChannelDataApiSuccess($app, $apiStartTime, $result);
        } catch (\Exception $e) {
            $this->logger->error('友盟API审计日志：外部系统交互异常', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId ?? 'unknown',
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'duration_ms' => round((microtime(true) - $apiStartTime) * 1000, 2),
            ]);

            $this->logChannelDataApiError($app, $apiStartTime, $e);
            throw $e;
        }

        return $result;
    }

    public function fetchDailyData(App $app, CarbonImmutable $date, string $version = '', string $channel = ''): \UmengUappGetDailyDataResult
    {
        $account = $app->getAccount();
        if (null === $account) {
            throw new InvalidAppException('App must have an associated account');
        }

        $syncApiClient = $this->clientFactory->createClient($account);
        $reqPolicy = $this->clientFactory->createRequestPolicy();
        $request = $this->createDailyDataRequest($app, $date, $version, $channel);
        $result = new \UmengUappGetDailyDataResult();

        $this->logDailyDataApiStart($app, $date, $version, $channel);
        $apiStartTime = microtime(true);

        try {
            $requestId = uniqid('umeng_', true);
            $this->logger->info('友盟API审计日志：外部系统交互开始', [
                'action' => 'SyncAPIClient::send()',
                'api' => 'umeng.uapp.getDailyData',
                'app_key' => $app->getAppKey(),
                'request_params' => [
                    'appkey' => $app->getAppKey(),
                    'date' => $date->format('Y-m-d'),
                    'version' => $version,
                    'channel' => $channel,
                ],
                'timestamp' => date('Y-m-d H:i:s'),
                'request_id' => $requestId,
            ]);

            $syncApiClient->send($request, $result, $reqPolicy);

            $endTime = microtime(true);
            $this->logger->info('友盟API审计日志：外部系统交互成功', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId,
                'duration_ms' => round(($endTime - $apiStartTime) * 1000, 2),
                'response_count' => null !== $result->getDailyData() ? 1 : 0,
            ]);

            $this->logDailyDataApiSuccess($app, $apiStartTime, $result);
        } catch (\Exception $e) {
            $this->logger->error('友盟API审计日志：外部系统交互异常', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId ?? 'unknown',
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'duration_ms' => round((microtime(true) - $apiStartTime) * 1000, 2),
            ]);

            $this->logDailyDataApiError($app, $apiStartTime, $e);
            throw $e;
        }

        return $result;
    }

    private function fetchLaunchesWithPeriodType(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate, string $periodType): \UmengUappGetLaunchesResult
    {
        $account = $app->getAccount();
        if (null === $account) {
            throw new InvalidAppException('App must have an associated account');
        }

        $syncApiClient = $this->clientFactory->createClient($account);
        $reqPolicy = $this->clientFactory->createRequestPolicy();
        $request = $this->createLaunchesRequestWithPeriodType($app, $startDate, $endDate, $periodType);
        $result = new \UmengUappGetLaunchesResult();

        $this->logLaunchesApiStart($app, $startDate, $endDate, $periodType);
        $apiStartTime = microtime(true);

        try {
            $requestId = uniqid('umeng_', true);
            $this->logger->info('友盟API审计日志：外部系统交互开始', [
                'action' => 'SyncAPIClient::send()',
                'api' => 'umeng.uapp.getLaunches',
                'app_key' => $app->getAppKey(),
                'request_params' => [
                    'appkey' => $app->getAppKey(),
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'period_type' => $periodType,
                ],
                'timestamp' => date('Y-m-d H:i:s'),
                'request_id' => $requestId,
            ]);

            $syncApiClient->send($request, $result, $reqPolicy);

            $endTime = microtime(true);
            $this->logger->info('友盟API审计日志：外部系统交互成功', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId,
                'duration_ms' => round(($endTime - $apiStartTime) * 1000, 2),
                'response_count' => null !== $result->getLaunchInfo() && (is_array($result->getLaunchInfo()) || $result->getLaunchInfo() instanceof \Countable) ? count($result->getLaunchInfo()) : 0,
            ]);

            $this->logLaunchesApiSuccess($app, $apiStartTime, $result, $periodType);
        } catch (\Exception $e) {
            $this->logger->error('友盟API审计日志：外部系统交互异常', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId ?? 'unknown',
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'duration_ms' => round((microtime(true) - $apiStartTime) * 1000, 2),
            ]);

            $this->logLaunchesApiError($app, $apiStartTime, $e, $periodType);
            throw $e;
        }

        return $result;
    }

    private function fetchActiveUsersWithPeriodType(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate, string $periodType): \UmengUappGetActiveUsersResult
    {
        $account = $app->getAccount();
        if (null === $account) {
            throw new InvalidAppException('App must have an associated account');
        }

        $syncApiClient = $this->clientFactory->createClient($account);
        $reqPolicy = $this->clientFactory->createRequestPolicy();
        $request = $this->createActiveUsersRequest($app, $startDate, $endDate, $periodType);
        $result = new \UmengUappGetActiveUsersResult();

        $this->logActiveUsersApiStart($app, $startDate, $endDate, $periodType);
        $apiStartTime = microtime(true);

        try {
            $requestId = uniqid('umeng_', true);
            $this->logger->info('友盟API审计日志：外部系统交互开始', [
                'action' => 'SyncAPIClient::send()',
                'api' => 'umeng.uapp.getActiveUsers',
                'app_key' => $app->getAppKey(),
                'request_params' => [
                    'appkey' => $app->getAppKey(),
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'period_type' => $periodType,
                ],
                'timestamp' => date('Y-m-d H:i:s'),
                'request_id' => $requestId,
            ]);

            $syncApiClient->send($request, $result, $reqPolicy);

            $endTime = microtime(true);
            $this->logger->info('友盟API审计日志：外部系统交互成功', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId,
                'duration_ms' => round(($endTime - $apiStartTime) * 1000, 2),
                'response_count' => null !== $result->getActiveUserInfo() && (is_array($result->getActiveUserInfo()) || $result->getActiveUserInfo() instanceof \Countable) ? count($result->getActiveUserInfo()) : 0,
            ]);

            $this->logActiveUsersApiSuccess($app, $apiStartTime, $result, $periodType);
        } catch (\Exception $e) {
            $this->logger->error('友盟API审计日志：外部系统交互异常', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId ?? 'unknown',
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'duration_ms' => round((microtime(true) - $apiStartTime) * 1000, 2),
            ]);

            $this->logActiveUsersApiError($app, $apiStartTime, $e, $periodType);
            throw $e;
        }

        return $result;
    }

    private function fetchNewUsersWithPeriodType(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate, string $periodType): \UmengUappGetNewUsersResult
    {
        $account = $app->getAccount();
        if (null === $account) {
            throw new InvalidAppException('App must have an associated account');
        }

        $syncApiClient = $this->clientFactory->createClient($account);
        $reqPolicy = $this->clientFactory->createRequestPolicy();
        $request = $this->createNewUsersRequest($app, $startDate, $endDate, $periodType);
        $result = new \UmengUappGetNewUsersResult();

        $this->logNewUsersApiStart($app, $startDate, $endDate, $periodType);
        $apiStartTime = microtime(true);

        try {
            $requestId = uniqid('umeng_', true);
            $this->logger->info('友盟API审计日志：外部系统交互开始', [
                'action' => 'SyncAPIClient::send()',
                'api' => 'umeng.uapp.getNewUsers',
                'app_key' => $app->getAppKey(),
                'request_params' => [
                    'appkey' => $app->getAppKey(),
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'period_type' => $periodType,
                ],
                'timestamp' => date('Y-m-d H:i:s'),
                'request_id' => $requestId,
            ]);

            $syncApiClient->send($request, $result, $reqPolicy);

            $endTime = microtime(true);
            $this->logger->info('友盟API审计日志：外部系统交互成功', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId,
                'duration_ms' => round(($endTime - $apiStartTime) * 1000, 2),
                'response_count' => null !== $result->getNewUserInfo() && (is_array($result->getNewUserInfo()) || $result->getNewUserInfo() instanceof \Countable) ? count($result->getNewUserInfo()) : 0,
            ]);

            $this->logNewUsersApiSuccess($app, $apiStartTime, $result, $periodType);
        } catch (\Exception $e) {
            $this->logger->error('友盟API审计日志：外部系统交互异常', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId ?? 'unknown',
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'duration_ms' => round((microtime(true) - $apiStartTime) * 1000, 2),
            ]);

            $this->logNewUsersApiError($app, $apiStartTime, $e, $periodType);
            throw $e;
        }

        return $result;
    }

    private function fetchRetentionsWithPeriodType(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate, string $periodType): \UmengUappGetRetentionsResult
    {
        $account = $app->getAccount();
        if (null === $account) {
            throw new InvalidAppException('App must have an associated account');
        }

        $syncApiClient = $this->clientFactory->createClient($account);
        $reqPolicy = $this->clientFactory->createRequestPolicy();
        $request = $this->createRetentionsRequest($app, $startDate, $endDate, $periodType);
        $result = new \UmengUappGetRetentionsResult();

        $this->logRetentionsApiStart($app, $startDate, $endDate, $periodType);
        $apiStartTime = microtime(true);

        try {
            $requestId = uniqid('umeng_', true);
            $this->logger->info('友盟API审计日志：外部系统交互开始', [
                'action' => 'SyncAPIClient::send()',
                'api' => 'umeng.uapp.getRetentions',
                'app_key' => $app->getAppKey(),
                'request_params' => [
                    'appkey' => $app->getAppKey(),
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'period_type' => $periodType,
                ],
                'timestamp' => date('Y-m-d H:i:s'),
                'request_id' => $requestId,
            ]);

            $syncApiClient->send($request, $result, $reqPolicy);

            $endTime = microtime(true);
            $this->logger->info('友盟API审计日志：外部系统交互成功', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId,
                'duration_ms' => round(($endTime - $apiStartTime) * 1000, 2),
                'response_count' => null !== $result->getRetentionInfo() && (is_array($result->getRetentionInfo()) || $result->getRetentionInfo() instanceof \Countable) ? count($result->getRetentionInfo()) : 0,
            ]);

            $this->logRetentionsApiSuccess($app, $apiStartTime, $result, $periodType);
        } catch (\Exception $e) {
            $this->logger->error('友盟API审计日志：外部系统交互异常', [
                'action' => 'SyncAPIClient::send()',
                'request_id' => $requestId ?? 'unknown',
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'duration_ms' => round((microtime(true) - $apiStartTime) * 1000, 2),
            ]);

            $this->logRetentionsApiError($app, $apiStartTime, $e, $periodType);
            throw $e;
        }

        return $result;
    }

    private function createAppListRequest(int $page, int $perPage): \APIRequest
    {
        $param = new \UmengUappGetAppListParam();
        $param->setPage($page);
        $param->setPerPage($perPage);
        $param->setAccessToken('');

        $request = new \APIRequest();
        $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getAppList', 1);
        $request->apiId = $apiId;
        $request->requestEntity = $param;

        return $request;
    }

    private function createLaunchesRequest(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \APIRequest
    {
        return $this->createLaunchesRequestWithPeriodType($app, $startDate, $endDate, 'daily');
    }

    private function createLaunchesRequestWithPeriodType(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate, string $periodType): \APIRequest
    {
        $appKey = $app->getAppKey();
        if (null === $appKey) {
            throw new InvalidAppException('App must have a valid app key');
        }

        $param = new \UmengUappGetLaunchesParam();
        $param->setAppkey($appKey);
        $param->setStartDate($startDate->format('Y-m-d'));
        $param->setEndDate($endDate->format('Y-m-d'));
        $param->setPeriodType($periodType);

        $request = new \APIRequest();
        $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getLaunches', 1);
        $request->apiId = $apiId;
        $request->requestEntity = $param;

        return $request;
    }

    private function createActiveUsersRequest(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate, string $periodType): \APIRequest
    {
        $appKey = $app->getAppKey();
        if (null === $appKey) {
            throw new InvalidAppException('App must have a valid app key');
        }

        $param = new \UmengUappGetActiveUsersParam();
        $param->setAppkey($appKey);
        $param->setStartDate($startDate->format('Y-m-d'));
        $param->setEndDate($endDate->format('Y-m-d'));
        $param->setPeriodType($periodType);

        $request = new \APIRequest();
        $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getActiveUsers', 1);
        $request->apiId = $apiId;
        $request->requestEntity = $param;

        return $request;
    }

    private function createNewUsersRequest(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate, string $periodType): \APIRequest
    {
        $appKey = $app->getAppKey();
        if (null === $appKey) {
            throw new InvalidAppException('App must have a valid app key');
        }

        $param = new \UmengUappGetNewUsersParam();
        $param->setAppkey($appKey);
        $param->setStartDate($startDate->format('Y-m-d'));
        $param->setEndDate($endDate->format('Y-m-d'));
        $param->setPeriodType($periodType);

        $request = new \APIRequest();
        $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getNewUsers', 1);
        $request->apiId = $apiId;
        $request->requestEntity = $param;

        return $request;
    }

    private function createRetentionsRequest(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate, string $periodType): \APIRequest
    {
        $appKey = $app->getAppKey();
        if (null === $appKey) {
            throw new InvalidAppException('App must have a valid app key');
        }

        $param = new \UmengUappGetRetentionsParam();
        $param->setAppkey($appKey);
        $param->setStartDate($startDate->format('Y-m-d'));
        $param->setEndDate($endDate->format('Y-m-d'));
        $param->setPeriodType($periodType);

        $request = new \APIRequest();
        $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getRetentions', 1);
        $request->apiId = $apiId;
        $request->requestEntity = $param;

        return $request;
    }

    private function createDurationRequest(App $app, CarbonImmutable $date, string $statType, string $version, string $channel): \APIRequest
    {
        $appKey = $app->getAppKey();
        if (null === $appKey) {
            throw new InvalidAppException('App must have a valid app key');
        }

        $param = new \UmengUappGetDurationsParam();
        $param->setAppkey($appKey);
        $param->setDate($date->format('Y-m-d'));
        $param->setStatType($statType);
        $param->setVersion($version);
        $param->setChannel($channel);

        $request = new \APIRequest();
        $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getDurations', 1);
        $request->apiId = $apiId;
        $request->requestEntity = $param;

        return $request;
    }

    private function createChannelDataRequest(App $app, CarbonImmutable $date, int $page, int $perPage): \APIRequest
    {
        $appKey = $app->getAppKey();
        if (null === $appKey) {
            throw new InvalidAppException('App must have a valid app key');
        }

        $param = new \UmengUappGetChannelDataParam();
        $param->setAppkey($appKey);
        $param->setDate($date->format('Y-m-d'));
        $param->setPage($page);
        $param->setPerPage($perPage);

        $request = new \APIRequest();
        $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getChannelData', 1);
        $request->apiId = $apiId;
        $request->requestEntity = $param;

        return $request;
    }

    private function createDailyDataRequest(App $app, CarbonImmutable $date, string $version, string $channel): \APIRequest
    {
        $appKey = $app->getAppKey();
        if (null === $appKey) {
            throw new InvalidAppException('App must have a valid app key');
        }

        $param = new \UmengUappGetDailyDataParam();
        $param->setAppkey($appKey);
        $param->setDate($date->format('Y-m-d'));
        $param->setVersion($version);
        $param->setChannel($channel);

        $request = new \APIRequest();
        $apiId = new \APIId('com.umeng.uapp', 'umeng.uapp.getDailyData', 1);
        $request->apiId = $apiId;
        $request->requestEntity = $param;

        return $request;
    }

    private function logApiStart(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $this->logLaunchesApiStart($app, $startDate, $endDate, 'daily');
    }

    private function logAppListApiStart(Account $account, int $page, int $perPage): void
    {
        $this->logger->info('友盟开放API调用开始', [
            'api' => 'umeng.uapp.getAppList',
            'account_id' => $account->getId(),
            'api_key' => $account->getApiKey(),
            'request_data' => [
                'page' => $page,
                'per_page' => $perPage,
            ],
        ]);
    }

    private function logLaunchesApiStart(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate, string $periodType): void
    {
        $this->logger->info('友盟开放API调用开始', [
            'api' => 'umeng.uapp.getLaunches',
            'app_key' => $app->getAppKey(),
            'request_data' => [
                'appkey' => $app->getAppKey(),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'period_type' => $periodType,
            ],
        ]);
    }

    private function logActiveUsersApiStart(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate, string $periodType): void
    {
        $this->logger->info('友盟开放API调用开始', [
            'api' => 'umeng.uapp.getActiveUsers',
            'app_key' => $app->getAppKey(),
            'request_data' => [
                'appkey' => $app->getAppKey(),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'period_type' => $periodType,
            ],
        ]);
    }

    private function logNewUsersApiStart(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate, string $periodType): void
    {
        $this->logger->info('友盟开放API调用开始', [
            'api' => 'umeng.uapp.getNewUsers',
            'app_key' => $app->getAppKey(),
            'request_data' => [
                'appkey' => $app->getAppKey(),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'period_type' => $periodType,
            ],
        ]);
    }

    private function logRetentionsApiStart(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate, string $periodType): void
    {
        $this->logger->info('友盟开放API调用开始', [
            'api' => 'umeng.uapp.getRetentions',
            'app_key' => $app->getAppKey(),
            'request_data' => [
                'appkey' => $app->getAppKey(),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'period_type' => $periodType,
            ],
        ]);
    }

    private function logDurationApiStart(App $app, CarbonImmutable $date, string $statType): void
    {
        $this->logger->info('友盟开放API调用开始', [
            'api' => 'umeng.uapp.getDurations',
            'app_key' => $app->getAppKey(),
            'request_data' => [
                'appkey' => $app->getAppKey(),
                'date' => $date->format('Y-m-d'),
                'stat_type' => $statType,
            ],
        ]);
    }

    private function logChannelDataApiStart(App $app, CarbonImmutable $date, int $page, int $perPage): void
    {
        $this->logger->info('友盟开放API调用开始', [
            'api' => 'umeng.uapp.getChannelData',
            'app_key' => $app->getAppKey(),
            'request_data' => [
                'appkey' => $app->getAppKey(),
                'date' => $date->format('Y-m-d'),
                'page' => $page,
                'per_page' => $perPage,
            ],
        ]);
    }

    private function logDailyDataApiStart(App $app, CarbonImmutable $date, string $version, string $channel): void
    {
        $this->logger->info('友盟开放API调用开始', [
            'api' => 'umeng.uapp.getDailyData',
            'app_key' => $app->getAppKey(),
            'request_data' => [
                'appkey' => $app->getAppKey(),
                'date' => $date->format('Y-m-d'),
                'version' => $version,
                'channel' => $channel,
            ],
        ]);
    }

    private function logApiSuccess(App $app, float $apiStartTime, \UmengUappGetLaunchesResult $result): void
    {
        $this->logLaunchesApiSuccess($app, $apiStartTime, $result, 'daily');
    }

    private function logAppListApiSuccess(Account $account, float $apiStartTime, \UmengUappGetAppListResult $result): void
    {
        $apiEndTime = microtime(true);
        $this->logger->info('友盟开放API调用成功', [
            'api' => 'umeng.uapp.getAppList',
            'account_id' => $account->getId(),
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'app_count' => $this->countItems($result->getAppInfos()),
        ]);
    }

    private function logLaunchesApiSuccess(App $app, float $apiStartTime, \UmengUappGetLaunchesResult $result, string $periodType): void
    {
        $apiEndTime = microtime(true);
        $this->logger->info('友盟开放API调用成功', [
            'api' => 'umeng.uapp.getLaunches',
            'app_key' => $app->getAppKey(),
            'period_type' => $periodType,
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'data_count' => $this->countItems($result->getLaunchInfo()),
        ]);
    }

    private function logActiveUsersApiSuccess(App $app, float $apiStartTime, \UmengUappGetActiveUsersResult $result, string $periodType): void
    {
        $apiEndTime = microtime(true);
        $this->logger->info('友盟开放API调用成功', [
            'api' => 'umeng.uapp.getActiveUsers',
            'app_key' => $app->getAppKey(),
            'period_type' => $periodType,
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'data_count' => $this->countItems($result->getActiveUserInfo()),
        ]);
    }

    private function logNewUsersApiSuccess(App $app, float $apiStartTime, \UmengUappGetNewUsersResult $result, string $periodType): void
    {
        $apiEndTime = microtime(true);
        $this->logger->info('友盟开放API调用成功', [
            'api' => 'umeng.uapp.getNewUsers',
            'app_key' => $app->getAppKey(),
            'period_type' => $periodType,
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'data_count' => $this->countItems($result->getNewUserInfo()),
        ]);
    }

    private function logRetentionsApiSuccess(App $app, float $apiStartTime, \UmengUappGetRetentionsResult $result, string $periodType): void
    {
        $apiEndTime = microtime(true);
        $this->logger->info('友盟开放API调用成功', [
            'api' => 'umeng.uapp.getRetentions',
            'app_key' => $app->getAppKey(),
            'period_type' => $periodType,
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'retention_info_count' => $this->countItems($result->getRetentionInfo()),
        ]);
    }

    private function logDurationApiSuccess(App $app, float $apiStartTime, \UmengUappGetDurationsResult $result, CarbonImmutable $date, string $statType): void
    {
        $apiEndTime = microtime(true);
        $this->logger->info('友盟开放API调用成功', [
            'api' => 'umeng.uapp.getDurations',
            'app_key' => $app->getAppKey(),
            'date' => $date->format('Y-m-d'),
            'stat_type' => $statType,
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'duration_info_count' => $this->countItems($result->getDurationInfos()),
        ]);
    }

    private function logChannelDataApiSuccess(App $app, float $apiStartTime, \UmengUappGetChannelDataResult $result): void
    {
        $apiEndTime = microtime(true);
        $this->logger->info('友盟开放API调用成功', [
            'api' => 'umeng.uapp.getChannelData',
            'app_key' => $app->getAppKey(),
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'channel_data_count' => $this->countItems($result->getChannelInfos()),
        ]);
    }

    private function logDailyDataApiSuccess(App $app, float $apiStartTime, \UmengUappGetDailyDataResult $result): void
    {
        $apiEndTime = microtime(true);
        $this->logger->info('友盟开放API调用成功', [
            'api' => 'umeng.uapp.getDailyData',
            'app_key' => $app->getAppKey(),
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'daily_data_count' => null !== $result->getDailyData() ? 1 : 0,
        ]);
    }

    private function logApiError(App $app, float $apiStartTime, \Exception $e): void
    {
        $this->logLaunchesApiError($app, $apiStartTime, $e, 'daily');
    }

    private function logAppListApiError(Account $account, float $apiStartTime, \Exception $e): void
    {
        $apiEndTime = microtime(true);
        $this->logger->error('友盟开放API调用失败', [
            'api' => 'umeng.uapp.getAppList',
            'account_id' => $account->getId(),
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    private function logLaunchesApiError(App $app, float $apiStartTime, \Exception $e, string $periodType): void
    {
        $apiEndTime = microtime(true);
        $this->logger->error('友盟开放API调用失败', [
            'api' => 'umeng.uapp.getLaunches',
            'app_key' => $app->getAppKey(),
            'period_type' => $periodType,
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    private function logActiveUsersApiError(App $app, float $apiStartTime, \Exception $e, string $periodType): void
    {
        $apiEndTime = microtime(true);
        $this->logger->error('友盟开放API调用失败', [
            'api' => 'umeng.uapp.getActiveUsers',
            'app_key' => $app->getAppKey(),
            'period_type' => $periodType,
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    private function logNewUsersApiError(App $app, float $apiStartTime, \Exception $e, string $periodType): void
    {
        $apiEndTime = microtime(true);
        $this->logger->error('友盟开放API调用失败', [
            'api' => 'umeng.uapp.getNewUsers',
            'app_key' => $app->getAppKey(),
            'period_type' => $periodType,
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    private function logRetentionsApiError(App $app, float $apiStartTime, \Exception $e, string $periodType): void
    {
        $apiEndTime = microtime(true);
        $this->logger->error('友盟开放API调用失败', [
            'api' => 'umeng.uapp.getRetentions',
            'app_key' => $app->getAppKey(),
            'period_type' => $periodType,
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    private function logDurationApiError(App $app, float $apiStartTime, \Exception $e, CarbonImmutable $date, string $statType): void
    {
        $apiEndTime = microtime(true);
        $this->logger->error('友盟开放API调用失败', [
            'api' => 'umeng.uapp.getDurations',
            'app_key' => $app->getAppKey(),
            'date' => $date->format('Y-m-d'),
            'stat_type' => $statType,
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    private function logChannelDataApiError(App $app, float $apiStartTime, \Exception $e): void
    {
        $apiEndTime = microtime(true);
        $this->logger->error('友盟开放API调用失败', [
            'api' => 'umeng.uapp.getChannelData',
            'app_key' => $app->getAppKey(),
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    private function logDailyDataApiError(App $app, float $apiStartTime, \Exception $e): void
    {
        $apiEndTime = microtime(true);
        $this->logger->error('友盟开放API调用失败', [
            'api' => 'umeng.uapp.getDailyData',
            'app_key' => $app->getAppKey(),
            'duration_ms' => round(($apiEndTime - $apiStartTime) * 1000, 2),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    /**
     * 计算可计数项目的数量
     */
    private function countItems(mixed $items): int
    {
        if (null === $items) {
            return 0;
        }
        if (is_array($items) || $items instanceof \Countable) {
            return count($items);
        }

        return 0;
    }
}
