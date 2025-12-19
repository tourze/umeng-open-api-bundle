<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyRetentions;

#[When(env: 'test')]
#[When(env: 'dev')]
final class DailyRetentionsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $app = $this->getReference(AppFixtures::VALID_ANDROID_APP_REFERENCE, App::class);

        $retentions = new DailyRetentions();
        $retentions->setApp($app);
        $retentions->setDate(CarbonImmutable::today()->subDays(1));
        $retentions->setTotalInstallUser(1000);
        $retentionData = [];
        $retentionData['1'] = 80.0;  // 1天后留存率80%
        $retentionData['3'] = 60.0;  // 3天后留存率60%
        $retentionData['7'] = 40.0;  // 7天后留存率40%
        $retentionData['30'] = 20.0; // 30天后留存率20%
        $retentions->setRetentionRate($retentionData);

        $manager->persist($retentions);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [AppFixtures::class];
    }
}
