<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\MonthlyRetentions;

#[When(env: 'test')]
#[When(env: 'dev')]
class MonthlyRetentionsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $app = $this->getReference(AppFixtures::VALID_ANDROID_APP_REFERENCE, App::class);

        $retentions = new MonthlyRetentions();
        $retentions->setApp($app);
        $retentions->setDate(CarbonImmutable::today()->subDays(1));
        $retentions->setTotalInstallUser(800);
        $retentions->setRetentionRate(65.5);

        $manager->persist($retentions);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [AppFixtures::class];
    }
}
