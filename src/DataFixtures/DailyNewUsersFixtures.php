<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyNewUsers;

#[When(env: 'test')]
#[When(env: 'dev')]
class DailyNewUsersFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $app = $this->getReference(AppFixtures::VALID_ANDROID_APP_REFERENCE, App::class);

        $newUsers = new DailyNewUsers();
        $newUsers->setApp($app);
        $newUsers->setDate(CarbonImmutable::today()->subDays(1));
        $newUsers->setValue(1500);

        $manager->persist($newUsers);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [AppFixtures::class];
    }
}
