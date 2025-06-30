<?php

namespace UmengOpenApiBundle\Tests\Integration\Exception;

class TestSetupException extends \RuntimeException
{
    public static function entityManagerNotFound(): self
    {
        return new self('EntityManager not found in container');
    }
}