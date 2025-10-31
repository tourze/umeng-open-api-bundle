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
use UmengOpenApiBundle\Entity\ThirtyDayActiveUsers;

/**
 * 友盟30天活跃用户统计管理控制器
 *
 * @extends AbstractCrudController<ThirtyDayActiveUsers>
 */
#[AdminCrud(routePath: '/umeng/thirty-day-active-users', routeName: 'umeng_thirty_day_active_users')]
final class ThirtyDayActiveUsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ThirtyDayActiveUsers::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),

            AssociationField::new('app', '关联应用')
                ->setRequired(true)
                ->setHelp('统计数据所属的应用'),

            DateTimeField::new('date', '统计日期')
                ->setRequired(true)
                ->setHelp('统计数据的日期')
                ->setFormat('yyyy-MM-dd'),

            IntegerField::new('value', '30天活跃用户数')
                ->setRequired(true)
                ->setHelp('过去30天的活跃用户数量'),

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
            ->setEntityLabelInSingular('30天统计活跃用户')
            ->setEntityLabelInPlural('30天统计活跃用户')
            ->setPageTitle('index', '30天统计活跃用户管理')
            ->setPageTitle('detail', '30天统计活跃用户详情')
            ->setPageTitle('edit', '编辑30天统计活跃用户')
            ->setPageTitle('new', '新建30天统计活跃用户')
            ->setDefaultSort(['createTime' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add('app')
            ->add('date')
            ->add('value')
            ->add('createTime')
            ->add('updateTime')
        ;
    }
}
