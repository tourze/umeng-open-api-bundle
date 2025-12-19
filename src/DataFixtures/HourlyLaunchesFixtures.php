<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\HourlyLaunches;

#[When(env: 'test')]
#[When(env: 'dev')]
final class HourlyLaunchesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $app = $this->getReference(AppFixtures::VALID_ANDROID_APP_REFERENCE, App::class);

        $hourlyLaunches = new HourlyLaunches();
        $hourlyLaunches->setApp($app);
        $hourlyLaunches->setDate(CarbonImmutable::today()->subDays(1));

        // 设置24小时的数据，模拟真实的用户行为模式
        $hourlyLaunches->setHour0(120);    // 0:00 - 深夜用户较少
        $hourlyLaunches->setHour1(80);     // 1:00
        $hourlyLaunches->setHour2(60);     // 2:00
        $hourlyLaunches->setHour3(40);     // 3:00
        $hourlyLaunches->setHour4(30);     // 4:00
        $hourlyLaunches->setHour5(50);     // 5:00 - 早起用户开始增加
        $hourlyLaunches->setHour6(150);    // 6:00
        $hourlyLaunches->setHour7(300);    // 7:00 - 早高峰
        $hourlyLaunches->setHour8(450);    // 8:00
        $hourlyLaunches->setHour9(400);    // 9:00
        $hourlyLaunches->setHour10(350);   // 10:00
        $hourlyLaunches->setHour11(320);   // 11:00
        $hourlyLaunches->setHour12(380);   // 12:00 - 午餐时间
        $hourlyLaunches->setHour13(340);   // 13:00
        $hourlyLaunches->setHour14(310);   // 14:00
        $hourlyLaunches->setHour15(290);   // 15:00
        $hourlyLaunches->setHour16(280);   // 16:00
        $hourlyLaunches->setHour17(320);   // 17:00
        $hourlyLaunches->setHour18(380);   // 18:00 - 下班后增加
        $hourlyLaunches->setHour19(420);   // 19:00 - 晚餐时间
        $hourlyLaunches->setHour20(450);   // 20:00 - 晚高峰
        $hourlyLaunches->setHour21(400);   // 21:00
        $hourlyLaunches->setHour22(320);   // 22:00
        $hourlyLaunches->setHour23(200);   // 23:00

        $manager->persist($hourlyLaunches);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [AppFixtures::class];
    }
}
