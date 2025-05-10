<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\Channel;
use UmengOpenApiBundle\Entity\DailyData;

class AppTest extends TestCase
{
    private App $app;

    protected function setUp(): void
    {
        $this->app = new App();
    }

    public function testGetSetName(): void
    {
        $name = 'Test App';
        $this->app->setName($name);
        $this->assertEquals($name, $this->app->getName());
    }

    public function testGetSetAppKey(): void
    {
        $appKey = 'app_key_12345';
        $this->app->setAppKey($appKey);
        $this->assertEquals($appKey, $this->app->getAppKey());
    }

    public function testGetSetPlatform(): void
    {
        $platform = 'android';
        $this->app->setPlatform($platform);
        $this->assertEquals($platform, $this->app->getPlatform());
    }

    public function testGetSetPopular(): void
    {
        $this->app->setPopular(true);
        $this->assertTrue($this->app->isPopular());

        $this->app->setPopular(false);
        $this->assertFalse($this->app->isPopular());

        $this->app->setPopular(null);
        $this->assertNull($this->app->isPopular());
    }

    public function testGetSetUseGameSdk(): void
    {
        $this->app->setUseGameSdk(true);
        $this->assertTrue($this->app->isUseGameSdk());

        $this->app->setUseGameSdk(false);
        $this->assertFalse($this->app->isUseGameSdk());

        $this->app->setUseGameSdk(null);
        $this->assertNull($this->app->isUseGameSdk());
    }

    public function testGetSetAccount(): void
    {
        $account = new Account();
        $this->app->setAccount($account);
        $this->assertSame($account, $this->app->getAccount());
    }

    public function testAddRemoveDailyData(): void
    {
        // 为当前App设置必需的Account关联
        $account = new Account();
        $this->app->setAccount($account);
        
        // 创建DailyData对象
        $dailyData = $this->createConfiguredMock(DailyData::class, [
            'getApp' => $this->app
        ]);
        
        // 模拟DailyData::setApp方法行为
        $dailyData->expects($this->any())
            ->method('setApp')
            ->with($this->logicalOr(
                $this->identicalTo($this->app),
                $this->isNull()
            ));
        
        // 初始应为空集合
        $this->assertCount(0, $this->app->getDailyData());
        
        // 添加测试
        $this->app->addDailyData($dailyData);
        
        // 通过反射检查是否添加成功
        $reflection = new \ReflectionClass($this->app);
        $property = $reflection->getProperty('dailyData');
        $property->setAccessible(true);
        $collection = $property->getValue($this->app);
        
        $this->assertCount(1, $collection);
        $this->assertTrue($collection->contains($dailyData));
    }

    public function testAddRemoveChannel(): void
    {
        // 为当前App设置必需的Account关联
        $account = new Account();
        $this->app->setAccount($account);
        
        // 创建Channel对象
        $channel = $this->createConfiguredMock(Channel::class, [
            'getApp' => $this->app
        ]);
        
        // 模拟Channel::setApp方法行为
        $channel->expects($this->any())
            ->method('setApp')
            ->with($this->logicalOr(
                $this->identicalTo($this->app),
                $this->isNull()
            ));
        
        // 初始应为空集合
        $this->assertCount(0, $this->app->getChannels());
        
        // 添加测试
        $this->app->addChannel($channel);
        
        // 通过反射检查是否添加成功
        $reflection = new \ReflectionClass($this->app);
        $property = $reflection->getProperty('channels');
        $property->setAccessible(true);
        $collection = $property->getValue($this->app);
        
        $this->assertCount(1, $collection);
        $this->assertTrue($collection->contains($channel));
    }

    public function testCreateUpdateTime(): void
    {
        $now = new \DateTime();
        
        $this->app->setCreateTime($now);
        $this->assertEquals($now, $this->app->getCreateTime());
        
        $updateTime = new \DateTime('+1 hour');
        $this->app->setUpdateTime($updateTime);
        $this->assertEquals($updateTime, $this->app->getUpdateTime());
    }
} 