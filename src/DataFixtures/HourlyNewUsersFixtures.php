<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\HourlyNewUsers;

#[When(env: 'test')]
#[When(env: 'dev')]
final class HourlyNewUsersFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $app = $this->getReference(AppFixtures::VALID_ANDROID_APP_REFERENCE, App::class);

        $newUsers = new HourlyNewUsers();
        $newUsers->setApp($app);
        $newUsers->setDate(CarbonImmutable::today()->subDays(1));

        // 设置24小时新用户数据，模拟新用户注册的时间分布
        $newUsers->setHour0(15);
        $newUsers->setHour1(12);
        $newUsers->setHour2(8);
        $newUsers->setHour3(6);
        $newUsers->setHour4(5);
        $newUsers->setHour5(9);
        $newUsers->setHour6(18);
        $newUsers->setHour7(35);
        $newUsers->setHour8(52);
        $newUsers->setHour9(68);
        $newUsers->setHour10(75);
        $newUsers->setHour11(82);
        $newUsers->setHour12(90);
        $newUsers->setHour13(88);
        $newUsers->setHour14(85);
        $newUsers->setHour15(78);
        $newUsers->setHour16(72);
        $newUsers->setHour17(65);
        $newUsers->setHour18(58);
        $newUsers->setHour19(52);
        $newUsers->setHour20(45);
        $newUsers->setHour21(38);
        $newUsers->setHour22(28);
        $newUsers->setHour23(22);

        $manager->persist($newUsers);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [AppFixtures::class];
    }
}
