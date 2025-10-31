<?php

namespace UmengOpenApiBundle\Tests\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;
use UmengOpenApiBundle\Exception\InvalidAppException;

/**
 * @internal
 */
#[CoversClass(InvalidAppException::class)]
final class InvalidAppExceptionTest extends AbstractExceptionTestCase
{
    public function testIsRuntimeException(): void
    {
        $exception = new InvalidAppException('test message');

        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertSame('test message', $exception->getMessage());
    }
}
