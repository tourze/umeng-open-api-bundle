<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\Account;

class AppTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $app = new App();
        
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
        $app = new App();
        
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
        $app = new App();
        $account = new Account();
        
        $app->setAccount($account);
        $this->assertSame($account, $app->getAccount());
    }

    public function testCollections(): void
    {
        $app = new App();
        
        $this->assertCount(0, $app->getDailyData());
        $this->assertCount(0, $app->getChannels());
    }

    public function testToString(): void
    {
        $app = new App();
        $this->assertEquals('', $app->__toString());
    }
}