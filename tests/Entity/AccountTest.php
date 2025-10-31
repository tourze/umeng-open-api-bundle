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
#[CoversClass(Account::class)]
final class AccountTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new Account();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'apps' => ['apps', new ArrayCollection()],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // 空实现，满足 TestCase 要求
    }

    public function testBasicProperties(): void
    {
        $account = $this->createAccount();

        $this->assertNull($account->getId());
        $this->assertNull($account->getName());
        $this->assertNull($account->getApiKey());
        $this->assertNull($account->getApiSecurity());
        $this->assertFalse($account->isValid());
    }

    public function testSettersAndGetters(): void
    {
        $account = $this->createAccount();

        $account->setName('Test Account');
        $this->assertEquals('Test Account', $account->getName());

        $account->setApiKey('test_api_key');
        $this->assertEquals('test_api_key', $account->getApiKey());

        $account->setApiSecurity('test_api_security');
        $this->assertEquals('test_api_security', $account->getApiSecurity());

        $account->setValid(true);
        $this->assertTrue($account->isValid());
    }

    public function testAppsCollection(): void
    {
        $account = $this->createAccount();
        $app = $this->createApp();

        $this->assertCount(0, $account->getApps());

        $account->addApp($app);
        $this->assertCount(1, $account->getApps());
        $this->assertTrue($account->getApps()->contains($app));
        $this->assertSame($account, $app->getAccount());

        $account->removeApp($app);
        $this->assertCount(0, $account->getApps());
        $this->assertNull($app->getAccount());
    }

    public function testToString(): void
    {
        $account = $this->createAccount();
        $this->assertEquals('', $account->__toString());
    }

    private function createAccount(): Account
    {
        return new Account();
    }

    private function createApp(): App
    {
        return new App();
    }
}
