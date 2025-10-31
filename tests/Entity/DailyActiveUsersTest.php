<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyActiveUsers;

/**
 * @internal
 */
#[CoversClass(DailyActiveUsers::class)]
final class DailyActiveUsersTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new DailyActiveUsers();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'value' => ['value', 123],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // 空实现，满足 TestCase 要求
    }

    public function testBasicProperties(): void
    {
        $dailyActiveUsers = $this->createDailyActiveUsers();

        $this->assertEquals(0, $dailyActiveUsers->getId());
    }

    public function testSettersAndGetters(): void
    {
        $dailyActiveUsers = $this->createDailyActiveUsers();
        $date = new \DateTime('2023-01-01');
        $app = $this->createApp();

        $dailyActiveUsers->setDate($date);
        $this->assertEquals($date, $dailyActiveUsers->getDate());

        $dailyActiveUsers->setValue(1000);
        $this->assertEquals(1000, $dailyActiveUsers->getValue());

        $dailyActiveUsers->setApp($app);
        $this->assertSame($app, $dailyActiveUsers->getApp());
    }

    public function testToString(): void
    {
        $dailyActiveUsers = $this->createDailyActiveUsers();
        $this->assertEquals('0', $dailyActiveUsers->__toString());
    }

    private function createDailyActiveUsers(): DailyActiveUsers
    {
        $reflection = new \ReflectionClass(DailyActiveUsers::class);

        return $reflection->newInstanceWithoutConstructor();
    }

    private function createApp(): App
    {
        $reflection = new \ReflectionClass(App::class);

        return $reflection->newInstanceWithoutConstructor();
    }
}
