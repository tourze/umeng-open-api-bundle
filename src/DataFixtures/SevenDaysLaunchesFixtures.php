<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\SevenDaysLaunches;

#[When(env: 'test')]
#[When(env: 'dev')]
class SevenDaysLaunchesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $app = $this->getReference(AppFixtures::VALID_ANDROID_APP_REFERENCE, App::class);

        $launches = new SevenDaysLaunches();
        $launches->setApp($app);
        $launches->setDate(CarbonImmutable::today()->subDays(1));
        $launches->setValue(35000);

        $manager->persist($launches);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [AppFixtures::class];
    }
}
