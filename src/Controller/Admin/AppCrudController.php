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
use UmengOpenApiBundle\Entity\App;

/**
 * 友盟应用管理控制器
 *
 * @extends AbstractCrudController<App>
 */
#[AdminCrud(routePath: '/umeng/app', routeName: 'umeng_app')]
final class AppCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return App::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),

            TextField::new('name', '应用名称')
                ->setRequired(true)
                ->setHelp('友盟应用的名称')
                ->setMaxLength(100),

            TextField::new('appKey', '应用密钥')
                ->setRequired(true)
                ->setHelp('友盟应用的唯一标识符')
                ->setMaxLength(40),

            TextField::new('platform', '平台')
                ->setRequired(true)
                ->setHelp('应用所属平台，如iOS、Android等')
                ->setMaxLength(20),

            BooleanField::new('popular', '是否关注')
                ->setRequired(false)
                ->setHelp('标记该应用是否为重点关注应用'),

            BooleanField::new('useGameSdk', '是否游戏应用')
                ->setRequired(false)
                ->setHelp('标记该应用是否使用游戏SDK'),

            AssociationField::new('account', '关联账户')
                ->setRequired(false)
                ->setHelp('该应用所属的友盟账户'),

            AssociationField::new('dailyData', '日统计数据')
                ->setRequired(false)
                ->setHelp('该应用的日统计数据记录')
                ->hideOnForm(),

            AssociationField::new('channels', '应用渠道')
                ->setRequired(false)
                ->setHelp('该应用下的所有渠道')
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
            ->setEntityLabelInSingular('友盟应用')
            ->setEntityLabelInPlural('友盟应用')
            ->setPageTitle('index', '友盟应用管理')
            ->setPageTitle('detail', '友盟应用详情')
            ->setPageTitle('edit', '编辑友盟应用')
            ->setPageTitle('new', '新建友盟应用')
            ->setDefaultSort(['createTime' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('appKey')
            ->add('platform')
            ->add('popular')
            ->add('useGameSdk')
            ->add('account')
            ->add('createTime')
            ->add('updateTime')
        ;
    }
}
