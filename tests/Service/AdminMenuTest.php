<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Tests\Service;

use Knp\Menu\MenuFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminMenuTestCase;
use UmengOpenApiBundle\Service\AdminMenu;

/**
 * AdminMenu服务测试
 * @internal
 */
#[CoversClass(AdminMenu::class)]
#[RunTestsInSeparateProcesses]
class AdminMenuTest extends AbstractEasyAdminMenuTestCase
{
    protected function onSetUp(): void
    {
        // Setup for AdminMenu tests
    }

    public function testInvokeAddsMenuItems(): void
    {
        $container = self::getContainer();
        /** @var AdminMenu $adminMenu */
        $adminMenu = $container->get(AdminMenu::class);

        $factory = new MenuFactory();
        $rootItem = $factory->createItem('root');

        $adminMenu->__invoke($rootItem);

        // 验证主菜单结构
        $statsMenu = $rootItem->getChild('统计分析');
        self::assertNotNull($statsMenu);

        $umengMenu = $statsMenu->getChild('友盟统计');
        self::assertNotNull($umengMenu);

        // 验证基础管理菜单
        $basicMenu = $umengMenu->getChild('基础管理');
        self::assertNotNull($basicMenu);
        self::assertNotNull($basicMenu->getChild('账户管理'));
        self::assertNotNull($basicMenu->getChild('应用管理'));
        self::assertNotNull($basicMenu->getChild('渠道管理'));

        // 验证日统计菜单
        $dailyMenu = $umengMenu->getChild('日统计');
        self::assertNotNull($dailyMenu);
        self::assertNotNull($dailyMenu->getChild('日活跃用户'));
        self::assertNotNull($dailyMenu->getChild('日新增用户'));
        self::assertNotNull($dailyMenu->getChild('日启动次数'));
        self::assertNotNull($dailyMenu->getChild('日使用时长'));

        // 验证小时统计菜单
        $hourlyMenu = $umengMenu->getChild('小时统计');
        self::assertNotNull($hourlyMenu);
        self::assertNotNull($hourlyMenu->getChild('小时活跃用户'));
        self::assertNotNull($hourlyMenu->getChild('小时新增用户'));
        self::assertNotNull($hourlyMenu->getChild('小时启动次数'));

        // 验证周统计菜单
        $weeklyMenu = $umengMenu->getChild('周统计');
        self::assertNotNull($weeklyMenu);
        self::assertNotNull($weeklyMenu->getChild('周活跃用户'));
        self::assertNotNull($weeklyMenu->getChild('周新增用户'));

        // 验证月统计菜单
        $monthlyMenu = $umengMenu->getChild('月统计');
        self::assertNotNull($monthlyMenu);
        self::assertNotNull($monthlyMenu->getChild('月活跃用户'));
        self::assertNotNull($monthlyMenu->getChild('月新增用户'));

        // 验证特殊周期菜单
        $specialMenu = $umengMenu->getChild('特殊周期');
        self::assertNotNull($specialMenu);
        self::assertNotNull($specialMenu->getChild('7天活跃用户'));
        self::assertNotNull($specialMenu->getChild('30天活跃用户'));
    }
}
