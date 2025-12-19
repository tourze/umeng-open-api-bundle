<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\WeeklyRetentions;

#[When(env: 'test')]
#[When(env: 'dev')]
final class WeeklyRetentionsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $app = $this->getReference(AppFixtures::VALID_ANDROID_APP_REFERENCE, App::class);

        $retentions = new WeeklyRetentions();
        $retentions->setApp($app);
        $retentions->setDate(CarbonImmutable::today()->subDays(1));
        $retentions->setTotalInstallUser(500);
        $retentions->setRetentionRate(75.2);

        $manager->persist($retentions);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [AppFixtures::class];
    }
}
