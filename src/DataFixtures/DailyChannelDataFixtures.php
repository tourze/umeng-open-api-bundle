<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\Channel;
use UmengOpenApiBundle\Entity\DailyChannelData;

#[When(env: 'test')]
#[When(env: 'dev')]
final class DailyChannelDataFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // 获取渠道引用
        $androidOfficialChannel = $this->getReference(ChannelFixtures::ANDROID_OFFICIAL_CHANNEL_REFERENCE, Channel::class);
        $androidHuaweiChannel = $this->getReference(ChannelFixtures::ANDROID_HUAWEI_CHANNEL_REFERENCE, Channel::class);
        $iosAppStoreChannel = $this->getReference(ChannelFixtures::IOS_APP_STORE_CHANNEL_REFERENCE, Channel::class);

        // 为 Android 官方渠道创建测试数据
        for ($i = 1; $i <= 5; ++$i) {
            $data = new DailyChannelData();
            $data->setChannel($androidOfficialChannel);
            $data->setDate(new \DateTimeImmutable('2024-01-0' . $i));
            $data->setLaunch(1000 * $i);
            $data->setDuration('3600');
            $data->setTotalUserRate(10.5 * $i);
            $data->setActiveUser(800 * $i);
            $data->setNewUser(200 * $i);
            $data->setTotalUser(5000 * $i);
            $manager->persist($data);
        }

        // 为 Android 华为渠道创建测试数据
        for ($i = 1; $i <= 3; ++$i) {
            $data = new DailyChannelData();
            $data->setChannel($androidHuaweiChannel);
            $data->setDate(new \DateTimeImmutable('2024-01-0' . $i));
            $data->setLaunch(800 * $i);
            $data->setDuration('3000');
            $data->setTotalUserRate(8.5 * $i);
            $data->setActiveUser(600 * $i);
            $data->setNewUser(150 * $i);
            $data->setTotalUser(4000 * $i);
            $manager->persist($data);
        }

        // 为 iOS App Store 渠道创建测试数据
        for ($i = 1; $i <= 4; ++$i) {
            $data = new DailyChannelData();
            $data->setChannel($iosAppStoreChannel);
            $data->setDate(new \DateTimeImmutable('2024-01-0' . $i));
            $data->setLaunch(1200 * $i);
            $data->setDuration('4000');
            $data->setTotalUserRate(15.0 * $i);
            $data->setActiveUser(1000 * $i);
            $data->setNewUser(300 * $i);
            $data->setTotalUser(6000 * $i);
            $manager->persist($data);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AccountFixtures::class,
            AppFixtures::class,
            ChannelFixtures::class,
        ];
    }
}
