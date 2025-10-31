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
use UmengOpenApiBundle\Entity\ThirtyDayNewUsers;

/**
 * 友盟30天新增用户统计管理控制器
 *
 * @extends AbstractCrudController<ThirtyDayNewUsers>
 */
#[AdminCrud(routePath: '/umeng/thirty-day-new-users', routeName: 'umeng_thirty_day_new_users')]
final class ThirtyDayNewUsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ThirtyDayNewUsers::class;
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

            IntegerField::new('value', '30天新增用户数')
                ->setRequired(true)
                ->setHelp('过去30天的新增用户数量'),

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
            ->setEntityLabelInSingular('30天统计新增用户')
            ->setEntityLabelInPlural('30天统计新增用户')
            ->setPageTitle('index', '30天统计新增用户管理')
            ->setPageTitle('detail', '30天统计新增用户详情')
            ->setPageTitle('edit', '编辑30天统计新增用户')
            ->setPageTitle('new', '新建30天统计新增用户')
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
