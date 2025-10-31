<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Service;

use Carbon\CarbonImmutable;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;

interface UmengDataFetcherInterface
{
    public function fetchAppList(Account $account, int $page = 1, int $perPage = 100): \UmengUappGetAppListResult;

    public function fetchDailyLaunches(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetLaunchesResult;

    public function fetchHourlyLaunches(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetLaunchesResult;

    public function fetchWeeklyLaunches(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetLaunchesResult;

    public function fetchMonthlyLaunches(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetLaunchesResult;

    public function fetchSevenDayLaunches(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetLaunchesResult;

    public function fetchThirtyDayLaunches(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetLaunchesResult;

    public function fetchDailyActiveUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetActiveUsersResult;

    public function fetchHourlyActiveUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetActiveUsersResult;

    public function fetchWeeklyActiveUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetActiveUsersResult;

    public function fetchMonthlyActiveUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetActiveUsersResult;

    public function fetchSevenDaysActiveUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetActiveUsersResult;

    public function fetchThirtyDayActiveUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetActiveUsersResult;

    public function fetchDailyNewUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetNewUsersResult;

    public function fetchHourlyNewUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetNewUsersResult;

    public function fetchWeeklyNewUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetNewUsersResult;

    public function fetchMonthlyNewUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetNewUsersResult;

    public function fetchSevenDayNewUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetNewUsersResult;

    public function fetchThirtyDayNewUsers(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetNewUsersResult;

    public function fetchDailyRetentions(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetRetentionsResult;

    public function fetchWeeklyRetentions(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetRetentionsResult;

    public function fetchMonthlyRetentions(App $app, CarbonImmutable $startDate, CarbonImmutable $endDate): \UmengUappGetRetentionsResult;

    public function fetchDurationData(App $app, CarbonImmutable $date, string $statType, string $version = '', string $channel = ''): \UmengUappGetDurationsResult;

    public function fetchChannelData(App $app, CarbonImmutable $date, int $page = 1, int $perPage = 100): \UmengUappGetChannelDataResult;

    public function fetchDailyData(App $app, CarbonImmutable $date, string $version = '', string $channel = ''): \UmengUappGetDailyDataResult;
}
