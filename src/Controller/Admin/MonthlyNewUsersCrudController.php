<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use UmengOpenApiBundle\Entity\MonthlyNewUsers;

/**
 * 友盟月新增用户统计管理控制器
 *
 * @extends AbstractCrudController<MonthlyNewUsers>
 */
#[AdminCrud(routePath: '/umeng/monthly-new-users', routeName: 'umeng_monthly_new_users')]
final class MonthlyNewUsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MonthlyNewUsers::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),

            AssociationField::new('app', '关联应用')
                ->setRequired(true)
                ->setHelp('统计数据所属的应用'),

            DateTimeField::new('date', '统计月份')
                ->setRequired(true)
                ->setHelp('统计数据的月份')
                ->setFormat('yyyy-MM'),

            IntegerField::new('value', '月新增用户数')
                ->setRequired(true)
                ->setHelp('当月的新增用户数量'),

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
            ->setEntityLabelInSingular('月统计新增用户')
            ->setEntityLabelInPlural('月统计新增用户')
            ->setPageTitle('index', '月统计新增用户管理')
            ->setPageTitle('detail', '月统计新增用户详情')
            ->setPageTitle('edit', '编辑月统计新增用户')
            ->setPageTitle('new', '新建月统计新增用户')
            ->setDefaultSort(['createTime' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('app')
            ->add('date')
            ->add('value')
            ->add('createTime')
            ->add('updateTime')
        ;
    }
}
