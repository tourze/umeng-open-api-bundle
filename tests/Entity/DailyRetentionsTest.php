<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyRetentions;

/**
 * @internal
 */
#[CoversClass(DailyRetentions::class)]
final class DailyRetentionsTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new DailyRetentions();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'totalInstallUser' => ['totalInstallUser', 1000],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // 空实现，满足 TestCase 要求
    }

    public function testBasicProperties(): void
    {
        $entity = $this->createDailyRetentions();

        $this->assertEquals(0, $entity->getId());
        $this->assertNull($entity->getTotalInstallUser());
        $this->assertNull($entity->getRetentionRate());
    }

    public function testSettersAndGetters(): void
    {
        $entity = $this->createDailyRetentions();
        $app = $this->createApp();
        $date = new \DateTimeImmutable('2024-01-01');

        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());

        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());

        $entity->setTotalInstallUser(1000);
        $this->assertEquals(1000, $entity->getTotalInstallUser());

        $retentionData = ['day_1' => 800, 'day_7' => 500, 'day_30' => 200];
        $entity->setRetentionRate($retentionData);
        $this->assertEquals($retentionData, $entity->getRetentionRate());
    }

    public function testToString(): void
    {
        $entity = $this->createDailyRetentions();
        $this->assertEquals('0', $entity->__toString());
    }

    private function createDailyRetentions(): DailyRetentions
    {
        $reflection = new \ReflectionClass(DailyRetentions::class);

        return $reflection->newInstanceWithoutConstructor();
    }

    private function createApp(): App
    {
        $reflection = new \ReflectionClass(App::class);

        return $reflection->newInstanceWithoutConstructor();
    }
}
