<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Tests\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminControllerTestCase;
use UmengOpenApiBundle\Controller\Admin\AccountCrudController;

/**
 * AccountCrudController Web测试
 *
 * @internal
 */
#[CoversClass(AccountCrudController::class)]
#[RunTestsInSeparateProcesses]
final class AccountCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    /** @phpstan-return AccountCrudController */
    protected function getControllerService(): AbstractCrudController
    {
        return self::getService(AccountCrudController::class);
    }

    /** @return iterable<string, array{string}> */
    public static function provideIndexPageHeaders(): iterable
    {
        yield 'item0' => ['ID'];
        yield 'item1' => ['账户名称'];
        yield 'item2' => ['API密钥'];
        yield 'item3' => ['API安全密钥'];
        yield 'item4' => ['是否有效'];
        yield 'item5' => ['关联应用'];
        yield 'item6' => ['创建时间'];
        yield 'item7' => ['更新时间'];
    }

    /** @return iterable<string, array{string}> */
    public static function provideNewPageFields(): iterable
    {
        yield 'item0' => ['name'];
        yield 'item1' => ['apiKey'];
        yield 'item2' => ['apiSecurity'];
        yield 'item3' => ['valid'];
    }

    /** @return iterable<string, array{string}> */
    public static function provideEditPageFields(): iterable
    {
        yield 'item0' => ['name'];
        yield 'item1' => ['apiKey'];
        yield 'item2' => ['apiSecurity'];
        yield 'item3' => ['valid'];
    }

    public function testControllerIsInstantiable(): void
    {
        $reflection = new \ReflectionClass(AccountCrudController::class);

        $this->assertTrue($reflection->isInstantiable());
        $this->assertTrue($reflection->isFinal());
    }

    public function testGetEntityFqcnShouldReturnAccountClass(): void
    {
        $this->assertEquals('UmengOpenApiBundle\Entity\Account', AccountCrudController::getEntityFqcn());
    }

    public function testControllerHasRequiredConfigurationMethods(): void
    {
        $reflection = new \ReflectionClass(AccountCrudController::class);

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
        $reflection = new \ReflectionClass(AccountCrudController::class);
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
        $reflection = new \ReflectionClass(AccountCrudController::class);

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
            (new \ReflectionClass(AccountCrudController::class))->getNamespaceName()
        );
    }

    public function testConfigureFieldsReturnsIterable(): void
    {
        $reflection = new \ReflectionClass(AccountCrudController::class);
        $method = $reflection->getMethod('configureFields');

        $this->assertTrue($method->isPublic());

        $returnType = $method->getReturnType();
        $this->assertNotNull($returnType);
        $this->assertInstanceOf(\ReflectionNamedType::class, $returnType);
        $this->assertEquals('iterable', $returnType->getName());
    }

    public function testControllerHasExpectedFieldConfiguration(): void
    {
        $reflection = new \ReflectionClass(AccountCrudController::class);
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
        $form = $crawler->filter('form[name="Account"]')->form();
        $client->submit($form);

        // 验证返回422状态码
        $this->assertResponseStatusCodeSame(422);

        // 验证响应内容包含必填字段错误信息
        $responseContent = $client->getResponse()->getContent();
        $this->assertIsString($responseContent);
        $this->assertStringContainsString('This value should not be blank', $responseContent);
    }

    /**
     * 测试新建表单提交验证
     */
    public function testNewFormSubmissionValidation(): void
    {
        $client = $this->createAuthenticatedClient();

        // 提交空表单，应该显示验证错误
        $crawler = $client->request('GET', $this->generateAdminUrl('new'));
        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form[name="Account"]')->form();
        $client->submit($form);

        // 验证必填字段错误（name, apiKey, apiSecurity 是必填的）
        $this->assertResponseStatusCodeSame(422); // 表单验证失败应返回422状态码
        $responseContent = $client->getResponse()->getContent();
        $this->assertNotNull($responseContent);

        // 验证页面包含验证错误信息
        $this->assertIsString($responseContent);
        $this->assertStringContainsString('This value should not be blank', $responseContent);
        $this->assertStringContainsString('has-error', $responseContent);
    }

    /**
     * 测试有效数据的表单提交
     */
    public function testValidFormSubmission(): void
    {
        $client = $this->createAuthenticatedClient();

        $crawler = $client->request('GET', $this->generateAdminUrl('new'));
        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form[name="Account"]')->form();
        $form['Account[name]'] = '测试友盟账户';
        $form['Account[apiKey]'] = 'test_api_key_12345678901234567890';
        $form['Account[apiSecurity]'] = 'test_api_security_12345678901234567890';
        $form['Account[valid]'] = '1';

        $client->submit($form);

        // 验证成功创建后重定向
        $this->assertResponseRedirects();
        $redirectUrl = $client->getResponse()->headers->get('Location');
        $this->assertNotNull($redirectUrl);

        // 跟随重定向
        $client->followRedirect();
        $this->assertResponseIsSuccessful();

        // 如果重定向到详情页，再访问列表页查看新记录
        $crawler = $client->request('GET', $this->generateAdminUrl('index'));
        $this->assertResponseIsSuccessful();

        // 验证新创建的账户出现在列表中
        $responseContent = $client->getResponse()->getContent();
        $this->assertNotNull($responseContent);
        $this->assertIsString($responseContent);
        $this->assertStringContainsString('测试友盟账户', $responseContent);
    }
}
