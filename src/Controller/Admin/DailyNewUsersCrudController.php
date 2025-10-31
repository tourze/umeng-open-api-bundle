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
use UmengOpenApiBundle\Entity\DailyNewUsers;

/**
 * 友盟日新增用户统计管理控制器
 *
 * @extends AbstractCrudController<DailyNewUsers>
 */
#[AdminCrud(routePath: '/umeng/daily-new-users', routeName: 'umeng_daily_new_users')]
final class DailyNewUsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DailyNewUsers::class;
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

            IntegerField::new('value', '新增用户数')
                ->setRequired(true)
                ->setHelp('当日的新增用户数量'),

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
            ->setEntityLabelInSingular('日统计新增用户')
            ->setEntityLabelInPlural('日统计新增用户')
            ->setPageTitle('index', '日统计新增用户管理')
            ->setPageTitle('detail', '日统计新增用户详情')
            ->setPageTitle('edit', '编辑日统计新增用户')
            ->setPageTitle('new', '新建日统计新增用户')
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
