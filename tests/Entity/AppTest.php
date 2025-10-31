<?php

namespace UmengOpenApiBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;

/**
 * @internal
 */
#[CoversClass(App::class)]
final class AppTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new App();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'name' => ['name', 'test_app'],
            'appKey' => ['appKey', 'test_key'],
            'platform' => ['platform', 'iOS'],
            'popular' => ['popular', true],
            'useGameSdk' => ['useGameSdk', false],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // 空实现，满足 TestCase 要求
    }

    public function testBasicProperties(): void
    {
        $app = $this->createApp();

        $this->assertNull($app->getId());
        $this->assertNull($app->getName());
        $this->assertNull($app->getAppKey());
        $this->assertNull($app->getPlatform());
        $this->assertNull($app->isPopular());
        $this->assertNull($app->isUseGameSdk());
        $this->assertNull($app->getAccount());
    }

    public function testSettersAndGetters(): void
    {
        $app = $this->createApp();

        $app->setName('Test App');
        $this->assertEquals('Test App', $app->getName());

        $app->setAppKey('test_app_key');
        $this->assertEquals('test_app_key', $app->getAppKey());

        $app->setPlatform('iOS');
        $this->assertEquals('iOS', $app->getPlatform());

        $app->setPopular(true);
        $this->assertTrue($app->isPopular());

        $app->setUseGameSdk(false);
        $this->assertFalse($app->isUseGameSdk());
    }

    public function testAccountRelation(): void
    {
        $app = $this->createApp();
        $account = $this->createAccount();

        $app->setAccount($account);
        $this->assertSame($account, $app->getAccount());
    }

    public function testCollections(): void
    {
        $app = $this->createApp();

        $this->assertCount(0, $app->getDailyData());
        $this->assertCount(0, $app->getChannels());
    }

    public function testToString(): void
    {
        $app = $this->createApp();
        $this->assertEquals('', $app->__toString());
    }

    private function createApp(): App
    {
        return new App();
    }

    private function createAccount(): Account
    {
        return new Account();
    }
}
