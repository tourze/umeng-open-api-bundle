<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyPerLaunchDuration;

#[When(env: 'test')]
#[When(env: 'dev')]
final class DailyPerLaunchDurationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $app = $this->getReference(AppFixtures::VALID_ANDROID_APP_REFERENCE, App::class);

        $durations = [
            ['0-3s', 120, 30.0],
            ['3-10s', 160, 40.0],
            ['10-30s', 80, 20.0],
            ['30s+', 40, 10.0],
        ];

        foreach ($durations as [$name, $value, $percent]) {
            $duration = new DailyPerLaunchDuration();
            $duration->setApp($app);
            $duration->setDate(CarbonImmutable::today()->subDays(1));
            $duration->setName($name);
            $duration->setValue($value);
            $duration->setPercent($percent);

            $manager->persist($duration);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [AppFixtures::class];
    }
}
