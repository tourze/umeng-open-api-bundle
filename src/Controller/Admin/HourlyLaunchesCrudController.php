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
use UmengOpenApiBundle\Entity\HourlyLaunches;

/**
 * 友盟小时启动次数统计管理控制器
 *
 * @extends AbstractCrudController<HourlyLaunches>
 */
#[AdminCrud(routePath: '/umeng/hourly-launches', routeName: 'umeng_hourly_launches')]
final class HourlyLaunchesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HourlyLaunches::class;
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

            // 24个小时字段
            IntegerField::new('hour0', '0时启动次数')
                ->setRequired(false)
                ->setHelp('0时的应用启动次数'),
            IntegerField::new('hour1', '1时启动次数')
                ->setRequired(false)
                ->setHelp('1时的应用启动次数'),
            IntegerField::new('hour2', '2时启动次数')
                ->setRequired(false)
                ->setHelp('2时的应用启动次数'),
            IntegerField::new('hour3', '3时启动次数')
                ->setRequired(false)
                ->setHelp('3时的应用启动次数'),
            IntegerField::new('hour4', '4时启动次数')
                ->setRequired(false)
                ->setHelp('4时的应用启动次数'),
            IntegerField::new('hour5', '5时启动次数')
                ->setRequired(false)
                ->setHelp('5时的应用启动次数'),
            IntegerField::new('hour6', '6时启动次数')
                ->setRequired(false)
                ->setHelp('6时的应用启动次数'),
            IntegerField::new('hour7', '7时启动次数')
                ->setRequired(false)
                ->setHelp('7时的应用启动次数'),
            IntegerField::new('hour8', '8时启动次数')
                ->setRequired(false)
                ->setHelp('8时的应用启动次数'),
            IntegerField::new('hour9', '9时启动次数')
                ->setRequired(false)
                ->setHelp('9时的应用启动次数'),
            IntegerField::new('hour10', '10时启动次数')
                ->setRequired(false)
                ->setHelp('10时的应用启动次数'),
            IntegerField::new('hour11', '11时启动次数')
                ->setRequired(false)
                ->setHelp('11时的应用启动次数'),
            IntegerField::new('hour12', '12时启动次数')
                ->setRequired(false)
                ->setHelp('12时的应用启动次数'),
            IntegerField::new('hour13', '13时启动次数')
                ->setRequired(false)
                ->setHelp('13时的应用启动次数'),
            IntegerField::new('hour14', '14时启动次数')
                ->setRequired(false)
                ->setHelp('14时的应用启动次数'),
            IntegerField::new('hour15', '15时启动次数')
                ->setRequired(false)
                ->setHelp('15时的应用启动次数'),
            IntegerField::new('hour16', '16时启动次数')
                ->setRequired(false)
                ->setHelp('16时的应用启动次数'),
            IntegerField::new('hour17', '17时启动次数')
                ->setRequired(false)
                ->setHelp('17时的应用启动次数'),
            IntegerField::new('hour18', '18时启动次数')
                ->setRequired(false)
                ->setHelp('18时的应用启动次数'),
            IntegerField::new('hour19', '19时启动次数')
                ->setRequired(false)
                ->setHelp('19时的应用启动次数'),
            IntegerField::new('hour20', '20时启动次数')
                ->setRequired(false)
                ->setHelp('20时的应用启动次数'),
            IntegerField::new('hour21', '21时启动次数')
                ->setRequired(false)
                ->setHelp('21时的应用启动次数'),
            IntegerField::new('hour22', '22时启动次数')
                ->setRequired(false)
                ->setHelp('22时的应用启动次数'),
            IntegerField::new('hour23', '23时启动次数')
                ->setRequired(false)
                ->setHelp('23时的应用启动次数'),

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
            ->setEntityLabelInSingular('小时统计启动次数')
            ->setEntityLabelInPlural('小时统计启动次数')
            ->setPageTitle('index', '小时统计启动次数管理')
            ->setPageTitle('detail', '小时统计启动次数详情')
            ->setPageTitle('edit', '编辑小时统计启动次数')
            ->setPageTitle('new', '新建小时统计启动次数')
            ->setDefaultSort(['createTime' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('app')
            ->add('date')
            ->add('hour0')
            ->add('hour8')
            ->add('hour12')
            ->add('hour18')
            ->add('createTime')
            ->add('updateTime')
        ;
    }
}
