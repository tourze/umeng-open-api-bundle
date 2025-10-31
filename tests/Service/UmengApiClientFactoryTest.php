<?php

namespace UmengOpenApiBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\Account;
use UmengOpenApiBundle\Service\UmengApiClientFactory;

/**
 * @internal
 */
#[CoversClass(UmengApiClientFactory::class)]
final class UmengApiClientFactoryTest extends TestCase
{
    private UmengApiClientFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new UmengApiClientFactory();
    }

    public function testCreateClient(): void
    {
        $account = $this->createMock(Account::class);
        $account->method('getApiKey')->willReturn('test_key');
        $account->method('getApiSecurity')->willReturn('test_secret');

        $client = $this->factory->createClient($account);

        $this->assertInstanceOf(\SyncAPIClient::class, $client);
    }

    public function testCreateRequestPolicy(): void
    {
        $policy = $this->factory->createRequestPolicy();

        $this->assertInstanceOf(\RequestPolicy::class, $policy);
        $this->assertSame('POST', $policy->httpMethod);
        $this->assertFalse($policy->needAuthorization);
        $this->assertFalse($policy->requestSendTimestamp);
        $this->assertTrue($policy->useHttps);
        $this->assertTrue($policy->useSignture);
        $this->assertFalse($policy->accessPrivateApi);
    }
}
