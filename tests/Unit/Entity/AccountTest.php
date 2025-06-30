<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;

class AccountTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $account = new Account();
        
        $this->assertNull($account->getId());
        $this->assertNull($account->getName());
        $this->assertNull($account->getApiKey());
        $this->assertNull($account->getApiSecurity());
        $this->assertFalse($account->isValid());
    }

    public function testSettersAndGetters(): void
    {
        $account = new Account();
        
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
        $account = new Account();
        $app = new App();
        
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
        $account = new Account();
        $this->assertEquals('', $account->__toString());
    }
}