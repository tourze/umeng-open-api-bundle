<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyNewUsers;

/**
 * @internal
 */
#[CoversClass(DailyNewUsers::class)]
final class DailyNewUsersTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new DailyNewUsers();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        // 创建一个 App 实例用于测试
        $reflection = new \ReflectionClass(App::class);
        $app = $reflection->newInstanceWithoutConstructor();

        return [
            'app' => ['app', $app],
            'date' => ['date', new \DateTimeImmutable('2024-01-01')],
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
        $entity = $this->createDailyNewUsers();

        $this->assertEquals(0, $entity->getId());
    }

    public function testSettersAndGetters(): void
    {
        $entity = $this->createDailyNewUsers();
        $app = $this->createApp();
        $date = new \DateTimeImmutable('2024-01-01');

        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());

        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());

        $entity->setValue(50);
        $this->assertEquals(50, $entity->getValue());
    }

    public function testToString(): void
    {
        $entity = $this->createDailyNewUsers();
        $this->assertEquals('0', $entity->__toString());
    }

    private function createDailyNewUsers(): DailyNewUsers
    {
        $reflection = new \ReflectionClass(DailyNewUsers::class);

        return $reflection->newInstanceWithoutConstructor();
    }

    private function createApp(): App
    {
        $reflection = new \ReflectionClass(App::class);

        return $reflection->newInstanceWithoutConstructor();
    }
}
