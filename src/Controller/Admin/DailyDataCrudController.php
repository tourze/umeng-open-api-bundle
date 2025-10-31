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
use UmengOpenApiBundle\Entity\DailyData;

/**
 * 友盟应用日统计数据管理控制器
 *
 * @extends AbstractCrudController<DailyData>
 */
#[AdminCrud(routePath: '/umeng/daily-data', routeName: 'umeng_daily_data')]
final class DailyDataCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DailyData::class;
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

            IntegerField::new('activityUsers', '活跃用户数')
                ->setRequired(false)
                ->setHelp('当日的活跃用户数量'),

            IntegerField::new('totalUsers', '总用户数')
                ->setRequired(false)
                ->setHelp('当日的累计总用户数'),

            IntegerField::new('launches', '启动数')
                ->setRequired(false)
                ->setHelp('当日的应用启动次数'),

            IntegerField::new('newUsers', '新增用户数')
                ->setRequired(false)
                ->setHelp('当日的新增用户数量'),

            IntegerField::new('payUsers', '付费用户数')
                ->setRequired(false)
                ->setHelp('当日的游戏付费用户数（仅游戏SDK）'),

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
            ->setEntityLabelInSingular('日统计数据')
            ->setEntityLabelInPlural('日统计数据')
            ->setPageTitle('index', '日统计数据管理')
            ->setPageTitle('detail', '日统计数据详情')
            ->setPageTitle('edit', '编辑日统计数据')
            ->setPageTitle('new', '新建日统计数据')
            ->setDefaultSort(['createTime' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('app')
            ->add('date')
            ->add('activityUsers')
            ->add('totalUsers')
            ->add('launches')
            ->add('newUsers')
            ->add('payUsers')
            ->add('createTime')
            ->add('updateTime')
        ;
    }
}
