<?php

namespace UmengOpenApiBundle\Tests\Service;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Exception\InvalidAppException;
use UmengOpenApiBundle\Service\UmengDataFetcher;

/**
 * @internal
 */
#[CoversClass(UmengDataFetcher::class)]
#[RunTestsInSeparateProcesses]
final class UmengDataFetcherTest extends AbstractIntegrationTestCase
{
    private UmengDataFetcher $dataFetcher;

    protected function onSetUp(): void
    {
        $this->dataFetcher = self::getService(UmengDataFetcher::class);
    }

    public function testFetchDailyLaunchesThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchDailyLaunches(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchDailyLaunchesThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchDailyLaunches(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchAppListReturnsResult(): void
    {
        $account = new Account();
        $account->setApiKey('test_api_key');
        $account->setApiSecurity('test_api_security');

        // 此测试仅验证方法可调用且返回正确类型
        // 实际 API 调用会失败，但方法应该返回结果对象
        $result = $this->dataFetcher->fetchAppList($account);

        $this->assertInstanceOf(\UmengUappGetAppListResult::class, $result);
    }

    public function testFetchHourlyLaunchesThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchHourlyLaunches(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchHourlyLaunchesThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchHourlyLaunches(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchWeeklyLaunchesThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchWeeklyLaunches(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchWeeklyLaunchesThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchWeeklyLaunches(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchMonthlyLaunchesThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchMonthlyLaunches(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchMonthlyLaunchesThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchMonthlyLaunches(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchSevenDayLaunchesThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchSevenDayLaunches(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchSevenDayLaunchesThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchSevenDayLaunches(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchThirtyDayLaunchesThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchThirtyDayLaunches(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchThirtyDayLaunchesThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchThirtyDayLaunches(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchDailyActiveUsersThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchDailyActiveUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchDailyActiveUsersThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchDailyActiveUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchHourlyActiveUsersThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchHourlyActiveUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchHourlyActiveUsersThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchHourlyActiveUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchWeeklyActiveUsersThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchWeeklyActiveUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchWeeklyActiveUsersThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchWeeklyActiveUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchMonthlyActiveUsersThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchMonthlyActiveUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchMonthlyActiveUsersThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchMonthlyActiveUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchSevenDaysActiveUsersThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchSevenDaysActiveUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchSevenDaysActiveUsersThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchSevenDaysActiveUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchThirtyDayActiveUsersThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchThirtyDayActiveUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchThirtyDayActiveUsersThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchThirtyDayActiveUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchDailyNewUsersThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchDailyNewUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchDailyNewUsersThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchDailyNewUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchHourlyNewUsersThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchHourlyNewUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchHourlyNewUsersThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchHourlyNewUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchWeeklyNewUsersThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchWeeklyNewUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchWeeklyNewUsersThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchWeeklyNewUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchMonthlyNewUsersThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchMonthlyNewUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchMonthlyNewUsersThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchMonthlyNewUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchSevenDayNewUsersThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchSevenDayNewUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchSevenDayNewUsersThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchSevenDayNewUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchThirtyDayNewUsersThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchThirtyDayNewUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchThirtyDayNewUsersThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchThirtyDayNewUsers(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchDailyRetentionsThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchDailyRetentions(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchDailyRetentionsThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchDailyRetentions(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchWeeklyRetentionsThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchWeeklyRetentions(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchWeeklyRetentionsThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchWeeklyRetentions(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchMonthlyRetentionsThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchMonthlyRetentions(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchMonthlyRetentionsThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchMonthlyRetentions(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            CarbonImmutable::parse('2024-01-31')
        );
    }

    public function testFetchDurationDataThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchDurationData(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            'daily'
        );
    }

    public function testFetchDurationDataThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchDurationData(
            $app,
            CarbonImmutable::parse('2024-01-01'),
            'daily'
        );
    }

    public function testFetchChannelDataThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchChannelData(
            $app,
            CarbonImmutable::parse('2024-01-01')
        );
    }

    public function testFetchChannelDataThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchChannelData(
            $app,
            CarbonImmutable::parse('2024-01-01')
        );
    }

    public function testFetchDailyDataThrowsExceptionWhenAppHasNoAccount(): void
    {
        $app = new App();
        // App without account

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have an associated account');

        $this->dataFetcher->fetchDailyData(
            $app,
            CarbonImmutable::parse('2024-01-01')
        );
    }

    public function testFetchDailyDataThrowsExceptionWhenAppHasNoAppKey(): void
    {
        $account = new Account();
        $app = new App();
        $app->setAccount($account);
        // App without app key (null by default)

        $this->expectException(InvalidAppException::class);
        $this->expectExceptionMessage('App must have a valid app key');

        $this->dataFetcher->fetchDailyData(
            $app,
            CarbonImmutable::parse('2024-01-01')
        );
    }
}
