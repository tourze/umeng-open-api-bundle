<?php

namespace UmengOpenApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\BundleDependency\BundleDependencyInterface;
use Tourze\EasyAdmin\Attribute\Permission\AsPermission;

#[AsPermission(title: '友盟数据')]
class UmengOpenApiBundle extends Bundle implements BundleDependencyInterface
{
    public static function getBundleDependencies(): array
    {
        return [
            \Tourze\Symfony\CronJob\CronJobBundle::class => ['all' => true],
        ];
    }
}
