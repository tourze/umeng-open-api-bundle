<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyActiveUsers;

#[When(env: 'test')]
#[When(env: 'dev')]
class DailyActiveUsersFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // 获取现有 App 的引用
        $app = $this->getReference(AppFixtures::VALID_IOS_APP_REFERENCE, App::class);

        // 创建测试数据
        for ($i = 1; $i <= 5; ++$i) {
            $data = new DailyActiveUsers();
            $data->setApp($app);
            $data->setDate(new \DateTimeImmutable('2024-01-0' . $i));
            $data->setValue(1000 * $i);
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
