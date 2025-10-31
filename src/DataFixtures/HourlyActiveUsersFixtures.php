<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\HourlyActiveUsers;

#[When(env: 'test')]
#[When(env: 'dev')]
class HourlyActiveUsersFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $app = $this->getReference(AppFixtures::VALID_ANDROID_APP_REFERENCE, App::class);

        $activeUsers = new HourlyActiveUsers();
        $activeUsers->setApp($app);
        $activeUsers->setDate(CarbonImmutable::today()->subDays(1));

        // 设置24小时活跃用户数据，模拟一天中的活跃度变化
        $activeUsers->setHour0(120);
        $activeUsers->setHour1(95);
        $activeUsers->setHour2(78);
        $activeUsers->setHour3(65);
        $activeUsers->setHour4(58);
        $activeUsers->setHour5(72);
        $activeUsers->setHour6(145);
        $activeUsers->setHour7(230);
        $activeUsers->setHour8(380);
        $activeUsers->setHour9(520);
        $activeUsers->setHour10(615);
        $activeUsers->setHour11(680);
        $activeUsers->setHour12(750);
        $activeUsers->setHour13(720);
        $activeUsers->setHour14(690);
        $activeUsers->setHour15(640);
        $activeUsers->setHour16(580);
        $activeUsers->setHour17(520);
        $activeUsers->setHour18(480);
        $activeUsers->setHour19(450);
        $activeUsers->setHour20(380);
        $activeUsers->setHour21(320);
        $activeUsers->setHour22(250);
        $activeUsers->setHour23(180);

        $manager->persist($activeUsers);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [AppFixtures::class];
    }
}
