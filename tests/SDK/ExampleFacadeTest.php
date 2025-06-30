<?php

namespace UmengOpenApiBundle\Tests\SDK;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../sdk/autoload.php';

class ExampleFacadeTest extends TestCase
{
    private \ExampleFacade $facade;

    protected function setUp(): void
    {
        $this->facade = new \ExampleFacade();
    }

    public function testSetServerHost(): void
    {
        $host = 'test.example.com';
        $this->facade->setServerHost($host);
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->facade);
        $property = $reflection->getProperty('serverHost');
        $property->setAccessible(true);
        
        $this->assertEquals($host, $property->getValue($this->facade));
    }

    public function testSetHttpPort(): void
    {
        $port = 8080;
        $this->facade->setHttpPort($port);
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->facade);
        $property = $reflection->getProperty('httpPort');
        $property->setAccessible(true);
        
        $this->assertEquals($port, $property->getValue($this->facade));
    }

    public function testSetHttpsPort(): void
    {
        $port = 8443;
        $this->facade->setHttpsPort($port);
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->facade);
        $property = $reflection->getProperty('httpsPort');
        $property->setAccessible(true);
        
        $this->assertEquals($port, $property->getValue($this->facade));
    }

    public function testSetAppKey(): void
    {
        $appKey = 'test-app-key';
        $this->facade->setAppKey($appKey);
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->facade);
        $property = $reflection->getProperty('appKey');
        $property->setAccessible(true);
        
        $this->assertEquals($appKey, $property->getValue($this->facade));
    }

    public function testSetSecKey(): void
    {
        $secKey = 'test-sec-key';
        $this->facade->setSecKey($secKey);
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->facade);
        $property = $reflection->getProperty('secKey');
        $property->setAccessible(true);
        
        $this->assertEquals($secKey, $property->getValue($this->facade));
    }

    public function testInitClient(): void
    {
        $this->facade->setAppKey('test-app-key');
        $this->facade->setSecKey('test-sec-key');
        $this->facade->initClient();
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->facade);
        $property = $reflection->getProperty('syncAPIClient');
        $property->setAccessible(true);
        
        $client = $property->getValue($this->facade);
        $this->assertInstanceOf(\SyncAPIClient::class, $client);
    }

    public function testGetAPIClient(): void
    {
        $this->facade->setAppKey('test-app-key');
        $this->facade->setSecKey('test-sec-key');
        
        $client = $this->facade->getAPIClient();
        $this->assertInstanceOf(\SyncAPIClient::class, $client);
        
        // 再次调用应该返回相同的实例
        $client2 = $this->facade->getAPIClient();
        $this->assertSame($client, $client2);
    }
}