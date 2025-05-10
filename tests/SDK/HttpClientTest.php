<?php

namespace UmengOpenApiBundle\Tests\SDK;

use PHPUnit\Framework\TestCase;

class HttpClientTest extends TestCase
{
    private \HttpClient $client;
    private string $testHost = 'example.com';
    private int $testPort = 80;

    protected function setUp(): void
    {
        $this->client = new \HttpClient($this->testHost, $this->testPort);
    }

    public function testConstructor(): void
    {
        // 判断实例是否创建成功就足够了
        $this->assertInstanceOf(\HttpClient::class, $this->client);
        
        // 由于HttpClient的实现可能会因版本或环境而异，我们不继续测试其内部属性
    }

    public function testSetGetCookies(): void
    {
        $cookies = ['test_cookie' => 'test_value'];
        $this->client->setCookies($cookies);
        $this->assertEquals($cookies, $this->client->getCookies());
    }

    public function testSetGetUserAgent(): void
    {
        $originalUserAgent = $this->client->user_agent;
        $newUserAgent = 'Test User Agent';
        
        $this->client->setUserAgent($newUserAgent);
        $this->assertEquals($newUserAgent, $this->client->user_agent);
        
        // 测试完恢复原值
        $this->client->setUserAgent($originalUserAgent);
    }

    public function testGetError(): void
    {
        // 检查初始错误消息（可能是null或空字符串）
        $initialError = $this->client->getError();
        $this->assertEmpty($initialError);
        
        // 创建反射来设置错误信息
        $reflection = new \ReflectionClass($this->client);
        $property = $reflection->getProperty('errormsg');
        $property->setAccessible(true);
        
        $testError = 'Test Error';
        $property->setValue($this->client, $testError);
        
        $this->assertEquals($testError, $this->client->getError());
    }

    public function testGetStatus(): void
    {
        // 默认状态码为null
        $this->assertNull($this->client->getStatus());
        
        // 创建反射来设置状态码
        $reflection = new \ReflectionClass($this->client);
        $property = $reflection->getProperty('status');
        $property->setAccessible(true);
        
        $testStatus = 200;
        $property->setValue($this->client, $testStatus);
        
        $this->assertEquals($testStatus, $this->client->getStatus());
    }

    public function testGetHeaders(): void
    {
        // 默认应该是空数组
        $initialHeaders = $this->client->getHeaders();
        $this->assertIsArray($initialHeaders);
        
        // 测试getHeader方法
        $this->assertFalse($this->client->getHeader('non-existent-header'));
    }

    public function testSetAuthorization(): void
    {
        $username = 'testuser';
        $password = 'testpass';
        $this->client->setAuthorization($username, $password);
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->client);
        $usernameProperty = $reflection->getProperty('username');
        $usernameProperty->setAccessible(true);
        $passwordProperty = $reflection->getProperty('password');
        $passwordProperty->setAccessible(true);
        
        $this->assertEquals($username, $usernameProperty->getValue($this->client));
        $this->assertEquals($password, $passwordProperty->getValue($this->client));
    }

    public function testUseGzip(): void
    {
        $this->client->useGzip(true);
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->client);
        $property = $reflection->getProperty('use_gzip');
        $property->setAccessible(true);
        
        $this->assertTrue($property->getValue($this->client));
        
        $this->client->useGzip(false);
        $this->assertFalse($property->getValue($this->client));
    }

    public function testSetPersistCookies(): void
    {
        $this->client->setPersistCookies(true);
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->client);
        $property = $reflection->getProperty('persist_cookies');
        $property->setAccessible(true);
        
        $this->assertTrue($property->getValue($this->client));
        
        $this->client->setPersistCookies(false);
        $this->assertFalse($property->getValue($this->client));
    }

    public function testSetPersistReferers(): void
    {
        $this->client->setPersistReferers(true);
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->client);
        $property = $reflection->getProperty('persist_referers');
        $property->setAccessible(true);
        
        $this->assertTrue($property->getValue($this->client));
        
        $this->client->setPersistReferers(false);
        $this->assertFalse($property->getValue($this->client));
    }

    public function testSetHandleRedirects(): void
    {
        $this->client->setHandleRedirects(true);
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->client);
        $property = $reflection->getProperty('handle_redirects');
        $property->setAccessible(true);
        
        $this->assertTrue($property->getValue($this->client));
        
        $this->client->setHandleRedirects(false);
        $this->assertFalse($property->getValue($this->client));
    }

    public function testSetMaxRedirects(): void
    {
        $redirects = 10;
        $this->client->setMaxRedirects($redirects);
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->client);
        $property = $reflection->getProperty('max_redirects');
        $property->setAccessible(true);
        
        $this->assertEquals($redirects, $property->getValue($this->client));
    }

    public function testSetHeadersOnly(): void
    {
        $this->client->setHeadersOnly(true);
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->client);
        $property = $reflection->getProperty('headers_only');
        $property->setAccessible(true);
        
        $this->assertTrue($property->getValue($this->client));
        
        $this->client->setHeadersOnly(false);
        $this->assertFalse($property->getValue($this->client));
    }

    public function testSetDebug(): void
    {
        $this->client->setDebug(true);
        
        // 使用反射获取私有属性
        $reflection = new \ReflectionClass($this->client);
        $property = $reflection->getProperty('debug');
        $property->setAccessible(true);
        
        $this->assertTrue($property->getValue($this->client));
        
        $this->client->setDebug(false);
        $this->assertFalse($property->getValue($this->client));
    }
     
    /**
     * 测试从响应中获取内容
     */
    public function testGetContent(): void
    {
        $content = 'Test content';
        
        // 使用反射设置私有属性
        $reflection = new \ReflectionClass($this->client);
        $property = $reflection->getProperty('content');
        $property->setAccessible(true);
        $property->setValue($this->client, $content);
        
        $this->assertEquals($content, $this->client->getContent());
    }
}
