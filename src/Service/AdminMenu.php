<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Service;

use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\EasyAdminMenuBundle\Service\MenuProviderInterface;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\Channel;
use UmengOpenApiBundle\Entity\DailyActiveUsers;
use UmengOpenApiBundle\Entity\DailyChannelData;
use UmengOpenApiBundle\Entity\DailyData;
use UmengOpenApiBundle\Entity\DailyDuration;
use UmengOpenApiBundle\Entity\DailyLaunches;
use UmengOpenApiBundle\Entity\DailyNewUsers;
use UmengOpenApiBundle\Entity\DailyPerLaunchDuration;
use UmengOpenApiBundle\Entity\DailyRetentions;
use UmengOpenApiBundle\Entity\HourlyActiveUsers;
use UmengOpenApiBundle\Entity\HourlyLaunches;
use UmengOpenApiBundle\Entity\HourlyNewUsers;
use UmengOpenApiBundle\Entity\MonthlyActiveUsers;
use UmengOpenApiBundle\Entity\MonthlyLaunches;
use UmengOpenApiBundle\Entity\MonthlyNewUsers;
use UmengOpenApiBundle\Entity\MonthlyRetentions;
use UmengOpenApiBundle\Entity\SevenDaysActiveUsers;
use UmengOpenApiBundle\Entity\SevenDaysLaunches;
use UmengOpenApiBundle\Entity\SevenDaysNewUsers;
use UmengOpenApiBundle\Entity\ThirtyDayActiveUsers;
use UmengOpenApiBundle\Entity\ThirtyDayLaunches;
use UmengOpenApiBundle\Entity\ThirtyDayNewUsers;
use UmengOpenApiBundle\Entity\WeeklyActiveUsers;
use UmengOpenApiBundle\Entity\WeeklyLaunches;
use UmengOpenApiBundle\Entity\WeeklyNewUsers;
use UmengOpenApiBundle\Entity\WeeklyRetentions;

/**
 * 友盟开放API统计数据管理后台菜单提供者
 */
#[Autoconfigure(public: true)]
readonly class AdminMenu implements MenuProviderInterface
{
    public function __construct(
        private LinkGeneratorInterface $linkGenerator,
    ) {
    }

    public function __invoke(ItemInterface $item): void
    {
        $statsMenu = $this->ensureStatsMenu($item);
        if (null === $statsMenu) {
            return;
        }

        $umengMenu = $this->ensureUmengMenu($statsMenu);
        if (null === $umengMenu) {
            return;
        }

        $this->addBasicManagementMenu($umengMenu);
        $this->addDailyStatsMenu($umengMenu);
        $this->addHourlyStatsMenu($umengMenu);
        $this->addWeeklyStatsMenu($umengMenu);
        $this->addMonthlyStatsMenu($umengMenu);
        $this->addSpecialPeriodMenu($umengMenu);
    }

    private function ensureStatsMenu(ItemInterface $item): ?ItemInterface
    {
        if (null === $item->getChild('统计分析')) {
            $item->addChild('统计分析');
        }

        return $item->getChild('统计分析');
    }

    private function ensureUmengMenu(ItemInterface $statsMenu): ?ItemInterface
    {
        if (null === $statsMenu->getChild('友盟统计')) {
            $statsMenu->addChild('友盟统计')
                ->setAttribute('icon', 'fas fa-chart-line')
            ;
        }

        return $statsMenu->getChild('友盟统计');
    }

    private function addBasicManagementMenu(ItemInterface $umengMenu): void
    {
        $basicMenu = $this->ensureChildMenu($umengMenu, '基础管理', 'fas fa-cog');
        if (null === $basicMenu) {
            return;
        }

        $this->addMenuItem($basicMenu, '账户管理', Account::class, 'fas fa-user-circle');
        $this->addMenuItem($basicMenu, '应用管理', App::class, 'fas fa-mobile-alt');
        $this->addMenuItem($basicMenu, '渠道管理', Channel::class, 'fas fa-share-alt');
    }

    private function addDailyStatsMenu(ItemInterface $umengMenu): void
    {
        $dailyMenu = $this->ensureChildMenu($umengMenu, '日统计', 'fas fa-calendar-day');
        if (null === $dailyMenu) {
            return;
        }

        $this->addMenuItem($dailyMenu, '日活跃用户', DailyActiveUsers::class, 'fas fa-users');
        $this->addMenuItem($dailyMenu, '日新增用户', DailyNewUsers::class, 'fas fa-user-plus');
        $this->addMenuItem($dailyMenu, '日启动次数', DailyLaunches::class, 'fas fa-play');
        $this->addMenuItem($dailyMenu, '日使用时长', DailyDuration::class, 'fas fa-clock');
        $this->addMenuItem($dailyMenu, '日平均时长', DailyPerLaunchDuration::class, 'fas fa-stopwatch');
        $this->addMenuItem($dailyMenu, '日用户留存', DailyRetentions::class, 'fas fa-user-check');
        $this->addMenuItem($dailyMenu, '日渠道数据', DailyChannelData::class, 'fas fa-share-alt-square');
        $this->addMenuItem($dailyMenu, '日统计总览', DailyData::class, 'fas fa-chart-bar');
    }

    private function addHourlyStatsMenu(ItemInterface $umengMenu): void
    {
        $hourlyMenu = $this->ensureChildMenu($umengMenu, '小时统计', 'fas fa-clock');
        if (null === $hourlyMenu) {
            return;
        }

        $this->addMenuItem($hourlyMenu, '小时活跃用户', HourlyActiveUsers::class, 'fas fa-users');
        $this->addMenuItem($hourlyMenu, '小时新增用户', HourlyNewUsers::class, 'fas fa-user-plus');
        $this->addMenuItem($hourlyMenu, '小时启动次数', HourlyLaunches::class, 'fas fa-play');
    }

    private function addWeeklyStatsMenu(ItemInterface $umengMenu): void
    {
        $weeklyMenu = $this->ensureChildMenu($umengMenu, '周统计', 'fas fa-calendar-week');
        if (null === $weeklyMenu) {
            return;
        }

        $this->addMenuItem($weeklyMenu, '周活跃用户', WeeklyActiveUsers::class, 'fas fa-users');
        $this->addMenuItem($weeklyMenu, '周新增用户', WeeklyNewUsers::class, 'fas fa-user-plus');
        $this->addMenuItem($weeklyMenu, '周启动次数', WeeklyLaunches::class, 'fas fa-play');
        $this->addMenuItem($weeklyMenu, '周用户留存', WeeklyRetentions::class, 'fas fa-user-check');
    }

    private function addMonthlyStatsMenu(ItemInterface $umengMenu): void
    {
        $monthlyMenu = $this->ensureChildMenu($umengMenu, '月统计', 'fas fa-calendar-alt');
        if (null === $monthlyMenu) {
            return;
        }

        $this->addMenuItem($monthlyMenu, '月活跃用户', MonthlyActiveUsers::class, 'fas fa-users');
        $this->addMenuItem($monthlyMenu, '月新增用户', MonthlyNewUsers::class, 'fas fa-user-plus');
        $this->addMenuItem($monthlyMenu, '月启动次数', MonthlyLaunches::class, 'fas fa-play');
        $this->addMenuItem($monthlyMenu, '月用户留存', MonthlyRetentions::class, 'fas fa-user-check');
    }

    private function addSpecialPeriodMenu(ItemInterface $umengMenu): void
    {
        $specialMenu = $this->ensureChildMenu($umengMenu, '特殊周期', 'fas fa-chart-pie');
        if (null === $specialMenu) {
            return;
        }

        $this->addMenuItem($specialMenu, '7天活跃用户', SevenDaysActiveUsers::class, 'fas fa-users');
        $this->addMenuItem($specialMenu, '7天新增用户', SevenDaysNewUsers::class, 'fas fa-user-plus');
        $this->addMenuItem($specialMenu, '7天启动次数', SevenDaysLaunches::class, 'fas fa-play');
        $this->addMenuItem($specialMenu, '30天活跃用户', ThirtyDayActiveUsers::class, 'fas fa-users');
        $this->addMenuItem($specialMenu, '30天新增用户', ThirtyDayNewUsers::class, 'fas fa-user-plus');
        $this->addMenuItem($specialMenu, '30天启动次数', ThirtyDayLaunches::class, 'fas fa-play');
    }

    private function ensureChildMenu(ItemInterface $parent, string $name, string $icon): ?ItemInterface
    {
        if (null === $parent->getChild($name)) {
            $parent->addChild($name)->setAttribute('icon', $icon);
        }

        return $parent->getChild($name);
    }

    /**
     * @param class-string $entityClass
     */
    private function addMenuItem(ItemInterface $parent, string $name, string $entityClass, string $icon): void
    {
        $parent->addChild($name)
            ->setUri($this->linkGenerator->getCurdListPage($entityClass))
            ->setAttribute('icon', $icon)
        ;
    }
}
