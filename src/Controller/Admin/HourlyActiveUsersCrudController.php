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
use UmengOpenApiBundle\Entity\HourlyActiveUsers;

/**
 * 友盟小时活跃用户统计管理控制器
 *
 * @extends AbstractCrudController<HourlyActiveUsers>
 */
#[AdminCrud(routePath: '/umeng/hourly-active-users', routeName: 'umeng_hourly_active_users')]
final class HourlyActiveUsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HourlyActiveUsers::class;
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
            IntegerField::new('hour0', '0时活跃用户')
                ->setRequired(false)
                ->setHelp('0时的活跃用户数'),
            IntegerField::new('hour1', '1时活跃用户')
                ->setRequired(false)
                ->setHelp('1时的活跃用户数'),
            IntegerField::new('hour2', '2时活跃用户')
                ->setRequired(false)
                ->setHelp('2时的活跃用户数'),
            IntegerField::new('hour3', '3时活跃用户')
                ->setRequired(false)
                ->setHelp('3时的活跃用户数'),
            IntegerField::new('hour4', '4时活跃用户')
                ->setRequired(false)
                ->setHelp('4时的活跃用户数'),
            IntegerField::new('hour5', '5时活跃用户')
                ->setRequired(false)
                ->setHelp('5时的活跃用户数'),
            IntegerField::new('hour6', '6时活跃用户')
                ->setRequired(false)
                ->setHelp('6时的活跃用户数'),
            IntegerField::new('hour7', '7时活跃用户')
                ->setRequired(false)
                ->setHelp('7时的活跃用户数'),
            IntegerField::new('hour8', '8时活跃用户')
                ->setRequired(false)
                ->setHelp('8时的活跃用户数'),
            IntegerField::new('hour9', '9时活跃用户')
                ->setRequired(false)
                ->setHelp('9时的活跃用户数'),
            IntegerField::new('hour10', '10时活跃用户')
                ->setRequired(false)
                ->setHelp('10时的活跃用户数'),
            IntegerField::new('hour11', '11时活跃用户')
                ->setRequired(false)
                ->setHelp('11时的活跃用户数'),
            IntegerField::new('hour12', '12时活跃用户')
                ->setRequired(false)
                ->setHelp('12时的活跃用户数'),
            IntegerField::new('hour13', '13时活跃用户')
                ->setRequired(false)
                ->setHelp('13时的活跃用户数'),
            IntegerField::new('hour14', '14时活跃用户')
                ->setRequired(false)
                ->setHelp('14时的活跃用户数'),
            IntegerField::new('hour15', '15时活跃用户')
                ->setRequired(false)
                ->setHelp('15时的活跃用户数'),
            IntegerField::new('hour16', '16时活跃用户')
                ->setRequired(false)
                ->setHelp('16时的活跃用户数'),
            IntegerField::new('hour17', '17时活跃用户')
                ->setRequired(false)
                ->setHelp('17时的活跃用户数'),
            IntegerField::new('hour18', '18时活跃用户')
                ->setRequired(false)
                ->setHelp('18时的活跃用户数'),
            IntegerField::new('hour19', '19时活跃用户')
                ->setRequired(false)
                ->setHelp('19时的活跃用户数'),
            IntegerField::new('hour20', '20时活跃用户')
                ->setRequired(false)
                ->setHelp('20时的活跃用户数'),
            IntegerField::new('hour21', '21时活跃用户')
                ->setRequired(false)
                ->setHelp('21时的活跃用户数'),
            IntegerField::new('hour22', '22时活跃用户')
                ->setRequired(false)
                ->setHelp('22时的活跃用户数'),
            IntegerField::new('hour23', '23时活跃用户')
                ->setRequired(false)
                ->setHelp('23时的活跃用户数'),

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
            ->setEntityLabelInSingular('小时统计活跃用户')
            ->setEntityLabelInPlural('小时统计活跃用户')
            ->setPageTitle('index', '小时统计活跃用户管理')
            ->setPageTitle('detail', '小时统计活跃用户详情')
            ->setPageTitle('edit', '编辑小时统计活跃用户')
            ->setPageTitle('new', '新建小时统计活跃用户')
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
