<?php

declare(strict_types=1);

namespace UmengOpenApiBundle;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\BundleDependency\BundleDependencyInterface;
use Tourze\Symfony\CronJob\CronJobBundle;

class UmengOpenApiBundle extends Bundle implements BundleDependencyInterface
{
    public static function getBundleDependencies(): array
    {
        return [
            DoctrineBundle::class => ['all' => true],
            CronJobBundle::class => ['all' => true],
        ];
    }
}
