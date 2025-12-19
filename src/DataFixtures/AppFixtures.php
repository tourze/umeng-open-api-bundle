<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;

#[When(env: 'test')]
#[When(env: 'dev')]
final class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public const VALID_ANDROID_APP_REFERENCE = 'valid-android-app';
    public const VALID_IOS_APP_REFERENCE = 'valid-ios-app';
    public const INVALID_ANDROID_APP_REFERENCE = 'invalid-android-app';
    public const INVALID_IOS_APP_REFERENCE = 'invalid-ios-app';

    public function load(ObjectManager $manager): void
    {
        // 获取账户引用
        $validAccount = $this->getReference(AccountFixtures::VALID_ACCOUNT_REFERENCE, Account::class);
        $invalidAccount = $this->getReference(AccountFixtures::INVALID_ACCOUNT_REFERENCE, Account::class);

        // 为有效账户创建 Android 应用
        $validAndroidApp = new App();
        $validAndroidApp->setName('测试Android应用');
        $validAndroidApp->setAppKey('test-android-app-key-123456');
        $validAndroidApp->setPlatform('android');
        $validAndroidApp->setPopular(true);
        $validAndroidApp->setUseGameSdk(false);
        $validAndroidApp->setAccount($validAccount);

        $manager->persist($validAndroidApp);

        // 为有效账户创建 iOS 应用
        $validIosApp = new App();
        $validIosApp->setName('测试iOS应用');
        $validIosApp->setAppKey('test-ios-app-key-123456');
        $validIosApp->setPlatform('ios');
        $validIosApp->setPopular(false);
        $validIosApp->setUseGameSdk(false);
        $validIosApp->setAccount($validAccount);

        $manager->persist($validIosApp);

        // 为无效账户创建 Android 应用
        $invalidAndroidApp = new App();
        $invalidAndroidApp->setName('停用Android应用');
        $invalidAndroidApp->setAppKey('test-android-app-key-987654');
        $invalidAndroidApp->setPlatform('android');
        $invalidAndroidApp->setPopular(false);
        $invalidAndroidApp->setUseGameSdk(true);
        $invalidAndroidApp->setAccount($invalidAccount);

        $manager->persist($invalidAndroidApp);

        // 为无效账户创建 iOS 应用
        $invalidIosApp = new App();
        $invalidIosApp->setName('停用iOS应用');
        $invalidIosApp->setAppKey('test-ios-app-key-987654');
        $invalidIosApp->setPlatform('ios');
        $invalidIosApp->setPopular(false);
        $invalidIosApp->setUseGameSdk(false);
        $invalidIosApp->setAccount($invalidAccount);

        $manager->persist($invalidIosApp);

        $manager->flush();

        // 设置引用，供其他 Fixtures 使用
        $this->addReference(self::VALID_ANDROID_APP_REFERENCE, $validAndroidApp);
        $this->addReference(self::VALID_IOS_APP_REFERENCE, $validIosApp);
        $this->addReference(self::INVALID_ANDROID_APP_REFERENCE, $invalidAndroidApp);
        $this->addReference(self::INVALID_IOS_APP_REFERENCE, $invalidIosApp);
    }

    public function getDependencies(): array
    {
        return [
            AccountFixtures::class,
        ];
    }
}
