<?php

namespace UmengOpenApiBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\BundleDependency\BundleDependencyInterface;
use UmengOpenApiBundle\UmengOpenApiBundle;

class UmengOpenApiBundleTest extends TestCase
{
    public function testBundleExtendsSymfonyBundle(): void
    {
        $bundle = new UmengOpenApiBundle();
        $this->assertInstanceOf(Bundle::class, $bundle);
    }

    public function testBundleImplementsBundleDependencyInterface(): void
    {
        $bundle = new UmengOpenApiBundle();
        $this->assertInstanceOf(BundleDependencyInterface::class, $bundle);
    }

    public function testGetBundleDependencies(): void
    {
        $dependencies = UmengOpenApiBundle::getBundleDependencies();
        
        // getBundleDependencies 返回的是数组，不需要再断言
        $this->assertArrayHasKey(\Tourze\Symfony\CronJob\CronJobBundle::class, $dependencies);
        $this->assertEquals(['all' => true], $dependencies[\Tourze\Symfony\CronJob\CronJobBundle::class]);
    }
}