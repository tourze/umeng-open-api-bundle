<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\MonthlyRetentions;

/**
 * @internal
 */
#[CoversClass(MonthlyRetentions::class)]
final class MonthlyRetentionsTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new MonthlyRetentions();
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
        $entity = $this->createMonthlyRetentions();

        $this->assertEquals(0, $entity->getId());
        $this->assertNull($entity->getTotalInstallUser());
        $this->assertNull($entity->getRetentionRate());
    }

    public function testSettersAndGetters(): void
    {
        $entity = $this->createMonthlyRetentions();
        $app = $this->createApp();
        $date = new \DateTimeImmutable('2024-01-01');

        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());

        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());

        $entity->setTotalInstallUser(5000);
        $this->assertEquals(5000, $entity->getTotalInstallUser());

        $entity->setRetentionRate(80.5);
        $this->assertEquals(80.5, $entity->getRetentionRate());
    }

    public function testToString(): void
    {
        $entity = $this->createMonthlyRetentions();
        $this->assertEquals('0', $entity->__toString());
    }

    private function createMonthlyRetentions(): MonthlyRetentions
    {
        $reflection = new \ReflectionClass(MonthlyRetentions::class);

        return $reflection->newInstanceWithoutConstructor();
    }

    private function createApp(): App
    {
        $reflection = new \ReflectionClass(App::class);

        return $reflection->newInstanceWithoutConstructor();
    }
}
