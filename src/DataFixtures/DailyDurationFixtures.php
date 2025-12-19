<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyDuration;

#[When(env: 'test')]
#[When(env: 'dev')]
final class DailyDurationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $app = $this->getReference(AppFixtures::VALID_ANDROID_APP_REFERENCE, App::class);

        $durations = [
            ['0-3s', 100, 25.0],
            ['3-10s', 150, 37.5],
            ['10-30s', 80, 20.0],
            ['30-60s', 40, 10.0],
            ['60-300s', 20, 5.0],
            ['300s+', 10, 2.5],
        ];

        foreach ($durations as [$name, $value, $percent]) {
            $duration = new DailyDuration();
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
