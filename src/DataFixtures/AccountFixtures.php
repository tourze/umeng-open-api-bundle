<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use UmengOpenApiBundle\Entity\Account;

#[When(env: 'test')]
#[When(env: 'dev')]
final class AccountFixtures extends Fixture
{
    public const VALID_ACCOUNT_REFERENCE = 'valid-account';
    public const INVALID_ACCOUNT_REFERENCE = 'invalid-account';

    public function load(ObjectManager $manager): void
    {
        // 创建有效的测试账户
        $validAccount = new Account();
        $validAccount->setName('测试友盟账户');
        $validAccount->setApiKey('test-api-key-valid-123456789');
        $validAccount->setApiSecurity('test-api-security-valid-123456789');
        $validAccount->setValid(true);

        $manager->persist($validAccount);

        // 创建无效的测试账户
        $invalidAccount = new Account();
        $invalidAccount->setName('已停用友盟账户');
        $invalidAccount->setApiKey('test-api-key-invalid-987654321');
        $invalidAccount->setApiSecurity('test-api-security-invalid-987654321');
        $invalidAccount->setValid(false);

        $manager->persist($invalidAccount);

        $manager->flush();

        // 设置引用，供其他 Fixtures 使用
        $this->addReference(self::VALID_ACCOUNT_REFERENCE, $validAccount);
        $this->addReference(self::INVALID_ACCOUNT_REFERENCE, $invalidAccount);
    }
}
