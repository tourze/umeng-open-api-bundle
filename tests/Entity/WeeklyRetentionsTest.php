<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\WeeklyRetentions;

/**
 * @internal
 */
#[CoversClass(WeeklyRetentions::class)]
final class WeeklyRetentionsTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new WeeklyRetentions();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'totalInstallUser' => ['totalInstallUser', 1000],
            'retentionRate' => ['retentionRate', 80.5],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // 空实现，满足 TestCase 要求
    }

    public function testBasicProperties(): void
    {
        $entity = $this->createWeeklyRetentions();

        $this->assertEquals(0, $entity->getId());
        $this->assertNull($entity->getTotalInstallUser());
        $this->assertNull($entity->getRetentionRate());
    }

    public function testSettersAndGetters(): void
    {
        $entity = $this->createWeeklyRetentions();
        $app = $this->createApp();
        $date = new \DateTimeImmutable('2024-01-01');

        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());

        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());

        $entity->setTotalInstallUser(2000);
        $this->assertEquals(2000, $entity->getTotalInstallUser());

        $entity->setRetentionRate(75.3);
        $this->assertEquals(75.3, $entity->getRetentionRate());
    }

    public function testToString(): void
    {
        $entity = $this->createWeeklyRetentions();
        $this->assertEquals('0', $entity->__toString());
    }

    private function createWeeklyRetentions(): WeeklyRetentions
    {
        $reflection = new \ReflectionClass(WeeklyRetentions::class);

        return $reflection->newInstanceWithoutConstructor();
    }

    private function createApp(): App
    {
        $reflection = new \ReflectionClass(App::class);

        return $reflection->newInstanceWithoutConstructor();
    }
}
