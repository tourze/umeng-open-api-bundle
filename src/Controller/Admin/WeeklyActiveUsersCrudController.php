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
use UmengOpenApiBundle\Entity\WeeklyActiveUsers;

/**
 * 友盟周活跃用户统计管理控制器
 *
 * @extends AbstractCrudController<WeeklyActiveUsers>
 */
#[AdminCrud(routePath: '/umeng/weekly-active-users', routeName: 'umeng_weekly_active_users')]
final class WeeklyActiveUsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WeeklyActiveUsers::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),

            AssociationField::new('app', '关联应用')
                ->setRequired(true)
                ->setHelp('统计数据所属的应用'),

            DateTimeField::new('date', '统计周期')
                ->setRequired(true)
                ->setHelp('统计数据的周期日期')
                ->setFormat('yyyy-MM-dd'),

            IntegerField::new('value', '周活跃用户数')
                ->setRequired(true)
                ->setHelp('当周的活跃用户数量'),

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
            ->setEntityLabelInSingular('周统计活跃用户')
            ->setEntityLabelInPlural('周统计活跃用户')
            ->setPageTitle('index', '周统计活跃用户管理')
            ->setPageTitle('detail', '周统计活跃用户详情')
            ->setPageTitle('edit', '编辑周统计活跃用户')
            ->setPageTitle('new', '新建周统计活跃用户')
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
