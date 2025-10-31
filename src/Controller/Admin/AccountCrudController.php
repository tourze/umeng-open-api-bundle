<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use UmengOpenApiBundle\Entity\Account;

/**
 * 友盟开放平台账户管理控制器
 *
 * @extends AbstractCrudController<Account>
 */
#[AdminCrud(routePath: '/umeng/account', routeName: 'umeng_account')]
final class AccountCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Account::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),

            TextField::new('name', '账户名称')
                ->setRequired(true)
                ->setHelp('友盟开放平台账户名称')
                ->setMaxLength(100),

            TextField::new('apiKey', 'API密钥')
                ->setRequired(true)
                ->setHelp('友盟开放平台API密钥，用于接口调用')
                ->setMaxLength(40),

            TextField::new('apiSecurity', 'API安全密钥')
                ->setRequired(true)
                ->setHelp('友盟开放平台API安全密钥，用于签名验证')
                ->setMaxLength(40),

            BooleanField::new('valid', '是否有效')
                ->setRequired(false)
                ->setHelp('标记该账户是否有效可用'),

            AssociationField::new('apps', '关联应用')
                ->setRequired(false)
                ->setHelp('该账户下的所有应用')
                ->hideOnForm(),

            DateTimeField::new('createTime', '创建时间')
                ->hideOnForm()
                ->setFormat('yyyy-MM-dd HH:mm:ss'),

            DateTimeField::new('updateTime', '更新时间')
                ->hideOnForm()
                ->setFormat('yyyy-MM-dd HH:mm:ss'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('友盟账户')
            ->setEntityLabelInPlural('友盟账户')
            ->setPageTitle('index', '友盟账户管理')
            ->setPageTitle('detail', '友盟账户详情')
            ->setPageTitle('edit', '编辑友盟账户')
            ->setPageTitle('new', '新建友盟账户')
            ->setDefaultSort(['createTime' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('valid')
            ->add('createTime')
            ->add('updateTime')
        ;
    }
}
