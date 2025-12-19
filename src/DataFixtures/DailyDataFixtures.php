<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyData;

#[When(env: 'test')]
#[When(env: 'dev')]
final class DailyDataFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // 获取现有 App 的引用
        $validAndroidApp = $this->getReference(AppFixtures::VALID_ANDROID_APP_REFERENCE, App::class);
        $validIosApp = $this->getReference(AppFixtures::VALID_IOS_APP_REFERENCE, App::class);

        // 为 Android 应用创建测试数据
        for ($i = 1; $i <= 5; ++$i) {
            $data = new DailyData();
            $data->setApp($validAndroidApp);
            $data->setDate(new \DateTimeImmutable('2024-01-0' . $i));
            $data->setActivityUsers(1000 * $i);
            $data->setTotalUsers(5000 * $i);
            $data->setLaunches(2000 * $i);
            $manager->persist($data);
        }

        // 为 iOS 应用创建测试数据
        for ($i = 1; $i <= 5; ++$i) {
            $data = new DailyData();
            $data->setApp($validIosApp);
            $data->setDate(new \DateTimeImmutable('2024-01-0' . $i));
            $data->setActivityUsers(1200 * $i);
            $data->setTotalUsers(6000 * $i);
            $data->setLaunches(2400 * $i);
            $manager->persist($data);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AccountFixtures::class,
            AppFixtures::class,
        ];
    }
}
