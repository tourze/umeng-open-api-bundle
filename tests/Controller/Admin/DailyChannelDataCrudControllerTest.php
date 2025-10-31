<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Tests\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminControllerTestCase;
use UmengOpenApiBundle\Controller\Admin\DailyChannelDataCrudController;

/**
 * DailyChannelDataCrudController Web测试
 *
 * @internal
 */
#[CoversClass(DailyChannelDataCrudController::class)]
#[RunTestsInSeparateProcesses]
final class DailyChannelDataCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    /** @phpstan-return DailyChannelDataCrudController */
    protected function getControllerService(): AbstractCrudController
    {
        return self::getService(DailyChannelDataCrudController::class);
    }

    /** @return iterable<string, array{string}> */
    public static function provideIndexPageHeaders(): iterable
    {
        yield 'item0' => ['ID'];
        yield 'item1' => ['关联渠道'];
        yield 'item2' => ['统计日期'];
        yield 'item3' => ['启动数'];
        yield 'item4' => ['使用时长(秒)'];
        yield 'item5' => ['总用户数比例(%)'];
        yield 'item6' => ['活跃用户数'];
        yield 'item7' => ['新增用户数'];
        yield 'item8' => ['总用户数'];
        yield 'item9' => ['创建时间'];
        yield 'item10' => ['更新时间'];
    }

    /** @return iterable<string, array{string}> */
    public static function provideNewPageFields(): iterable
    {
        yield 'item0' => ['channel'];
        yield 'item1' => ['date'];
        yield 'item2' => ['launch'];
        yield 'item3' => ['duration'];
        yield 'item4' => ['totalUserRate'];
        yield 'item5' => ['activeUser'];
        yield 'item6' => ['newUser'];
        yield 'item7' => ['totalUser'];
    }

    /** @return iterable<string, array{string}> */
    public static function provideEditPageFields(): iterable
    {
        yield 'item0' => ['channel'];
        yield 'item1' => ['date'];
        yield 'item2' => ['launch'];
        yield 'item3' => ['duration'];
        yield 'item4' => ['totalUserRate'];
        yield 'item5' => ['activeUser'];
        yield 'item6' => ['newUser'];
        yield 'item7' => ['totalUser'];
    }

    public function testControllerIsInstantiable(): void
    {
        $reflection = new \ReflectionClass(DailyChannelDataCrudController::class);

        $this->assertTrue($reflection->isInstantiable());
        $this->assertTrue($reflection->isFinal());
    }

    public function testGetEntityFqcnShouldReturnDailyChannelDataClass(): void
    {
        $this->assertEquals('UmengOpenApiBundle\Entity\DailyChannelData', DailyChannelDataCrudController::getEntityFqcn());
    }

    public function testControllerHasRequiredConfigurationMethods(): void
    {
        $reflection = new \ReflectionClass(DailyChannelDataCrudController::class);

        $requiredMethods = [
            'getEntityFqcn',
            'configureFields',
        ];

        foreach ($requiredMethods as $methodName) {
            $this->assertTrue($reflection->hasMethod($methodName), "方法 {$methodName} 必须存在");

            $method = $reflection->getMethod($methodName);
            $this->assertTrue($method->isPublic(), "方法 {$methodName} 必须是public");
        }
    }

    public function testControllerHasCorrectAnnotations(): void
    {
        $reflection = new \ReflectionClass(DailyChannelDataCrudController::class);
        $attributes = $reflection->getAttributes();

        $hasAdminCrudAttribute = false;
        foreach ($attributes as $attribute) {
            if (str_contains($attribute->getName(), 'AdminCrud')) {
                $hasAdminCrudAttribute = true;
                break;
            }
        }

        $this->assertTrue($hasAdminCrudAttribute, 'Controller应该有AdminCrud注解');
    }

    public function testControllerStructure(): void
    {
        $reflection = new \ReflectionClass(DailyChannelDataCrudController::class);

        // 测试类是final的
        $this->assertTrue($reflection->isFinal());

        // 测试继承关系
        $this->assertTrue($reflection->isSubclassOf('EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController'));

        // 测试getEntityFqcn是静态方法
        $getEntityMethod = $reflection->getMethod('getEntityFqcn');
        $this->assertTrue($getEntityMethod->isStatic());
        $this->assertTrue($getEntityMethod->isPublic());
    }

    public function testControllerHasProperNamespace(): void
    {
        $this->assertEquals(
            'UmengOpenApiBundle\Controller\Admin',
            (new \ReflectionClass(DailyChannelDataCrudController::class))->getNamespaceName()
        );
    }

    public function testConfigureFieldsReturnsIterable(): void
    {
        $reflection = new \ReflectionClass(DailyChannelDataCrudController::class);
        $method = $reflection->getMethod('configureFields');

        $this->assertTrue($method->isPublic());

        $returnType = $method->getReturnType();
        $this->assertNotNull($returnType);
        $returnTypeName = $returnType instanceof \ReflectionNamedType ? $returnType->getName() : (string) $returnType;
        $this->assertEquals('iterable', $returnTypeName);
    }

    public function testControllerHasExpectedFieldConfiguration(): void
    {
        $reflection = new \ReflectionClass(DailyChannelDataCrudController::class);
        $method = $reflection->getMethod('configureFields');

        // 验证方法签名
        $parameters = $method->getParameters();
        $this->assertCount(1, $parameters);
        $this->assertEquals('pageName', $parameters[0]->getName());

        $parameterType = $parameters[0]->getType();
        $this->assertInstanceOf(\ReflectionNamedType::class, $parameterType);
        $this->assertEquals('string', $parameterType->getName());
    }

    public function testValidationErrors(): void
    {
        $client = $this->createAuthenticatedClient();

        // 访问新建页面
        $crawler = $client->request('GET', $this->generateAdminUrl('new'));
        $this->assertResponseIsSuccessful();

        // 提交空表单
        $form = $crawler->filter('form[name="DailyChannelData"]')->form();
        $client->submit($form);

        // 验证返回422状态码
        $this->assertResponseStatusCodeSame(422);

        // 验证响应内容包含必填字段错误信息
        $responseContent = $client->getResponse()->getContent();
        $this->assertIsString($responseContent);
        $this->assertStringContainsString('This value should not be null', $responseContent);
    }
}
