<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;
use UmengOpenApiBundle\UmengOpenApiBundle;

/**
 * @internal
 */
#[CoversClass(UmengOpenApiBundle::class)]
#[RunTestsInSeparateProcesses]
final class UmengOpenApiBundleTest extends AbstractBundleTestCase
{
}
