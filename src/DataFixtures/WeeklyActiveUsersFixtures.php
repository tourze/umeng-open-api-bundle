<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\WeeklyActiveUsers;

#[When(env: 'test')]
#[When(env: 'dev')]
class WeeklyActiveUsersFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $app = $this->getReference(AppFixtures::VALID_ANDROID_APP_REFERENCE, App::class);

        $activeUsers = new WeeklyActiveUsers();
        $activeUsers->setApp($app);
        $activeUsers->setDate(CarbonImmutable::today()->subDays(1));
        $activeUsers->setValue(8500);

        $manager->persist($activeUsers);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [AppFixtures::class];
    }
}
