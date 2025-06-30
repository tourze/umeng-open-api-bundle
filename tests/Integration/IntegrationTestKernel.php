<?php

namespace UmengOpenApiBundle\Tests\Integration;

use Snc\RedisBundle\SncRedisBundle;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\AsyncCommandBundle\AsyncCommandBundle;
use Tourze\IntegrationTestKernel\IntegrationTestKernel as BaseIntegrationTestKernel;
use Tourze\LockServiceBundle\LockServiceBundle;
use Tourze\RoutingAutoLoaderBundle\RoutingAutoLoaderBundle;
use Tourze\Symfony\CronJob\CronJobBundle;
use UmengOpenApiBundle\UmengOpenApiBundle;

class IntegrationTestKernel extends BaseIntegrationTestKernel
{
    public function __construct()
    {
        parent::__construct(
            'test',
            true,
            [
                SncRedisBundle::class => ['all' => true],
                AsyncCommandBundle::class => ['all' => true],
                RoutingAutoLoaderBundle::class => ['all' => true],
                LockServiceBundle::class => ['all' => true],
                CronJobBundle::class => ['all' => true],
                UmengOpenApiBundle::class => ['all' => true],
            ],
            [
                'UmengOpenApiBundle\Entity' => dirname(__DIR__, 2) . '/src/Entity',
            ],
            function (ContainerBuilder $container) {
                // Redis 配置
                $container->loadFromExtension('snc_redis', [
                    'clients' => [
                        'default' => [
                            'type' => 'phpredis',
                            'alias' => 'default',
                            'dsn' => 'redis://127.0.0.1:6379',
                            'logging' => false,
                            'options' => [
                                'connection_timeout' => 1,
                                'read_write_timeout' => 1,
                            ],
                        ],
                    ],
                ]);

                // AsyncCommandBundle 需要的配置
                $container->setParameter('kernel.runtime_mode_env', 'prod');
            },
            function (ContainerBuilder $container) {
                // 添加编译器 pass 来确保 Repository 服务是 public
                $container->addCompilerPass(new class implements CompilerPassInterface {
                    public function process(ContainerBuilder $container): void
                    {
                        foreach ($container->getDefinitions() as $id => $definition) {
                            if (str_starts_with($id, 'UmengOpenApiBundle\\Repository\\')) {
                                $definition->setPublic(true);
                            }
                        }
                    }
                });
            }
        );
    }
} 