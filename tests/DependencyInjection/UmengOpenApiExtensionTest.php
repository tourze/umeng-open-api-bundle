<?php

namespace UmengOpenApiBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use UmengOpenApiBundle\DependencyInjection\UmengOpenApiExtension;

class UmengOpenApiExtensionTest extends TestCase
{
    private UmengOpenApiExtension $extension;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->extension = new UmengOpenApiExtension();
        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
    }

    public function testLoadExtension(): void
    {
        $this->extension->load([], $this->container);
        
        // 验证容器中是否存在相应的服务定义
        $this->assertTrue($this->container->hasDefinition('UmengOpenApiBundle\Command\GetAppListCommand') || 
                         $this->container->hasAlias('UmengOpenApiBundle\Command\GetAppListCommand'));
    }
    
    public function testServicesConfiguration(): void
    {
        $this->extension->load([], $this->container);
        
        // 检查服务定义是否存在
        $this->assertTrue($this->container->hasDefinition('UmengOpenApiBundle\Command\GetAppListCommand') || 
                         $this->container->hasAlias('UmengOpenApiBundle\Command\GetAppListCommand'));
        
        // 跳过服务实例化测试，因为这需要完整的依赖
        // 只检查服务定义是否正确
        if ($this->container->hasDefinition('UmengOpenApiBundle\Command\GetAppListCommand')) {
            $definition = $this->container->getDefinition('UmengOpenApiBundle\Command\GetAppListCommand');
            $this->assertTrue($definition->isAutowired() || $definition->getClass() !== null);
        }
    }
} 