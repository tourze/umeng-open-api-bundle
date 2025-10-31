<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\Channel;

#[When(env: 'test')]
#[When(env: 'dev')]
class ChannelFixtures extends Fixture implements DependentFixtureInterface
{
    public const ANDROID_OFFICIAL_CHANNEL_REFERENCE = 'android-official-channel';
    public const ANDROID_HUAWEI_CHANNEL_REFERENCE = 'android-huawei-channel';
    public const IOS_APP_STORE_CHANNEL_REFERENCE = 'ios-app-store-channel';

    public function load(ObjectManager $manager): void
    {
        // 获取应用引用
        $validAndroidApp = $this->getReference(AppFixtures::VALID_ANDROID_APP_REFERENCE, App::class);
        $validIosApp = $this->getReference(AppFixtures::VALID_IOS_APP_REFERENCE, App::class);

        // 为 Android 应用创建官方渠道
        $androidOfficialChannel = new Channel();
        $androidOfficialChannel->setName('Android官方渠道');
        $androidOfficialChannel->setCode('ANDROID001');
        $androidOfficialChannel->setApp($validAndroidApp);

        $manager->persist($androidOfficialChannel);

        // 为 Android 应用创建华为应用市场渠道
        $androidHuaweiChannel = new Channel();
        $androidHuaweiChannel->setName('华为应用市场');
        $androidHuaweiChannel->setCode('HUAWEI001');
        $androidHuaweiChannel->setApp($validAndroidApp);

        $manager->persist($androidHuaweiChannel);

        // 为 iOS 应用创建 App Store 渠道
        $iosAppStoreChannel = new Channel();
        $iosAppStoreChannel->setName('App Store官方');
        $iosAppStoreChannel->setCode('APPSTORE1');
        $iosAppStoreChannel->setApp($validIosApp);

        $manager->persist($iosAppStoreChannel);

        $manager->flush();

        // 设置引用，供其他 Fixtures 使用
        $this->addReference(self::ANDROID_OFFICIAL_CHANNEL_REFERENCE, $androidOfficialChannel);
        $this->addReference(self::ANDROID_HUAWEI_CHANNEL_REFERENCE, $androidHuaweiChannel);
        $this->addReference(self::IOS_APP_STORE_CHANNEL_REFERENCE, $iosAppStoreChannel);
    }

    public function getDependencies(): array
    {
        return [
            AppFixtures::class,
        ];
    }
}
