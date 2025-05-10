<?php

namespace UmengOpenApiBundle\Tests\Integration;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Tourze\Symfony\CronJob\CronJobBundle;
use UmengOpenApiBundle\UmengOpenApiBundle;

class IntegrationTestKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new DoctrineBundle(),
            new CronJobBundle(),
            new UmengOpenApiBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->loadFromExtension('framework', [
                'test' => true,
                'secret' => 'test',
            ]);

            $container->loadFromExtension('doctrine', [
                'dbal' => [
                    'driver' => 'pdo_sqlite',
                    'path' => ':memory:',
                    'memory' => true,
                ],
                'orm' => [
                    'auto_generate_proxy_classes' => true,
                    'auto_mapping' => true,
                    'mappings' => [
                        'UmengOpenApiBundle' => [
                            'is_bundle' => true,
                            'type' => 'attribute',
                            'dir' => 'Entity',
                            'prefix' => 'UmengOpenApiBundle\Entity',
                        ],
                    ],
                ],
            ]);
        });
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir() . '/UmengOpenApiBundle/cache/' . $this->environment;
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir() . '/UmengOpenApiBundle/logs';
    }
} 