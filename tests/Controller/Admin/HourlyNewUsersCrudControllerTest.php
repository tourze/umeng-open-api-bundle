<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Tests\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminControllerTestCase;
use UmengOpenApiBundle\Controller\Admin\HourlyNewUsersCrudController;

/**
 * HourlyNewUsersCrudController Web测试
 *
 * @internal
 */
#[CoversClass(HourlyNewUsersCrudController::class)]
#[RunTestsInSeparateProcesses]
final class HourlyNewUsersCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    /** @phpstan-return HourlyNewUsersCrudController */
    protected function getControllerService(): AbstractCrudController
    {
        return self::getService(HourlyNewUsersCrudController::class);
    }

    /** @return iterable<string, array{string}> */
    public static function provideIndexPageHeaders(): iterable
    {
        yield 'item0' => ['ID'];
        yield 'item1' => ['关联应用'];
        yield 'item2' => ['统计日期'];
        yield 'item3' => ['0时新增用户'];
        yield 'item4' => ['1时新增用户'];
        yield 'item5' => ['2时新增用户'];
        yield 'item6' => ['3时新增用户'];
        yield 'item7' => ['4时新增用户'];
        yield 'item8' => ['5时新增用户'];
        yield 'item9' => ['6时新增用户'];
        yield 'item10' => ['7时新增用户'];
        yield 'item11' => ['8时新增用户'];
        yield 'item12' => ['9时新增用户'];
        yield 'item13' => ['10时新增用户'];
        yield 'item14' => ['11时新增用户'];
        yield 'item15' => ['12时新增用户'];
        yield 'item16' => ['13时新增用户'];
        yield 'item17' => ['14时新增用户'];
        yield 'item18' => ['15时新增用户'];
        yield 'item19' => ['16时新增用户'];
        yield 'item20' => ['17时新增用户'];
        yield 'item21' => ['18时新增用户'];
        yield 'item22' => ['19时新增用户'];
        yield 'item23' => ['20时新增用户'];
        yield 'item24' => ['21时新增用户'];
        yield 'item25' => ['22时新增用户'];
        yield 'item26' => ['23时新增用户'];
        yield 'item27' => ['创建时间'];
        yield 'item28' => ['更新时间'];
    }

    /** @return iterable<string, array{string}> */
    public static function provideNewPageFields(): iterable
    {
        yield 'item0' => ['app'];
        yield 'item1' => ['date'];
        yield 'item2' => ['hour0'];
    }

    /** @return iterable<string, array{string}> */
    public static function provideEditPageFields(): iterable
    {
        yield 'item0' => ['app'];
        yield 'item1' => ['date'];
        yield 'item2' => ['hour0'];
    }

    public function testControllerIsInstantiable(): void
    {
        $reflection = new \ReflectionClass(HourlyNewUsersCrudController::class);

        $this->assertTrue($reflection->isInstantiable());
        $this->assertTrue($reflection->isFinal());
    }

    public function testControllerHasRequiredConfigurationMethods(): void
    {
        $reflection = new \ReflectionClass(HourlyNewUsersCrudController::class);

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
        $reflection = new \ReflectionClass(HourlyNewUsersCrudController::class);
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
        $reflection = new \ReflectionClass(HourlyNewUsersCrudController::class);

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
            (new \ReflectionClass(HourlyNewUsersCrudController::class))->getNamespaceName()
        );
    }

    public function testConfigureFieldsReturnsIterable(): void
    {
        $reflection = new \ReflectionClass(HourlyNewUsersCrudController::class);
        $method = $reflection->getMethod('configureFields');

        $this->assertTrue($method->isPublic());

        $returnType = $method->getReturnType();
        $this->assertNotNull($returnType);
        $returnTypeName = $returnType instanceof \ReflectionNamedType ? $returnType->getName() : (string) $returnType;
        $this->assertEquals('iterable', $returnTypeName);
    }

    public function testControllerHasExpectedFieldConfiguration(): void
    {
        $reflection = new \ReflectionClass(HourlyNewUsersCrudController::class);
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
        $form = $crawler->filter('form[name="HourlyNewUsers"]')->form();
        $client->submit($form);

        // 验证返回422状态码
        $this->assertResponseStatusCodeSame(422);

        // 验证响应内容包含必填字段错误信息
        $responseContent = $client->getResponse()->getContent();
        $this->assertIsString($responseContent);
        $this->assertStringContainsString('This value should not be null', $responseContent);
    }
}
