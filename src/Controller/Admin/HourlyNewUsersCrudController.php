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
use UmengOpenApiBundle\Entity\HourlyNewUsers;

/**
 * 友盟小时新增用户统计管理控制器
 *
 * @extends AbstractCrudController<HourlyNewUsers>
 */
#[AdminCrud(routePath: '/umeng/hourly-new-users', routeName: 'umeng_hourly_new_users')]
final class HourlyNewUsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HourlyNewUsers::class;
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
            IntegerField::new('hour0', '0时新增用户')
                ->setRequired(false)
                ->setHelp('0时的新增用户数'),
            IntegerField::new('hour1', '1时新增用户')
                ->setRequired(false)
                ->setHelp('1时的新增用户数'),
            IntegerField::new('hour2', '2时新增用户')
                ->setRequired(false)
                ->setHelp('2时的新增用户数'),
            IntegerField::new('hour3', '3时新增用户')
                ->setRequired(false)
                ->setHelp('3时的新增用户数'),
            IntegerField::new('hour4', '4时新增用户')
                ->setRequired(false)
                ->setHelp('4时的新增用户数'),
            IntegerField::new('hour5', '5时新增用户')
                ->setRequired(false)
                ->setHelp('5时的新增用户数'),
            IntegerField::new('hour6', '6时新增用户')
                ->setRequired(false)
                ->setHelp('6时的新增用户数'),
            IntegerField::new('hour7', '7时新增用户')
                ->setRequired(false)
                ->setHelp('7时的新增用户数'),
            IntegerField::new('hour8', '8时新增用户')
                ->setRequired(false)
                ->setHelp('8时的新增用户数'),
            IntegerField::new('hour9', '9时新增用户')
                ->setRequired(false)
                ->setHelp('9时的新增用户数'),
            IntegerField::new('hour10', '10时新增用户')
                ->setRequired(false)
                ->setHelp('10时的新增用户数'),
            IntegerField::new('hour11', '11时新增用户')
                ->setRequired(false)
                ->setHelp('11时的新增用户数'),
            IntegerField::new('hour12', '12时新增用户')
                ->setRequired(false)
                ->setHelp('12时的新增用户数'),
            IntegerField::new('hour13', '13时新增用户')
                ->setRequired(false)
                ->setHelp('13时的新增用户数'),
            IntegerField::new('hour14', '14时新增用户')
                ->setRequired(false)
                ->setHelp('14时的新增用户数'),
            IntegerField::new('hour15', '15时新增用户')
                ->setRequired(false)
                ->setHelp('15时的新增用户数'),
            IntegerField::new('hour16', '16时新增用户')
                ->setRequired(false)
                ->setHelp('16时的新增用户数'),
            IntegerField::new('hour17', '17时新增用户')
                ->setRequired(false)
                ->setHelp('17时的新增用户数'),
            IntegerField::new('hour18', '18时新增用户')
                ->setRequired(false)
                ->setHelp('18时的新增用户数'),
            IntegerField::new('hour19', '19时新增用户')
                ->setRequired(false)
                ->setHelp('19时的新增用户数'),
            IntegerField::new('hour20', '20时新增用户')
                ->setRequired(false)
                ->setHelp('20时的新增用户数'),
            IntegerField::new('hour21', '21时新增用户')
                ->setRequired(false)
                ->setHelp('21时的新增用户数'),
            IntegerField::new('hour22', '22时新增用户')
                ->setRequired(false)
                ->setHelp('22时的新增用户数'),
            IntegerField::new('hour23', '23时新增用户')
                ->setRequired(false)
                ->setHelp('23时的新增用户数'),

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
            ->setEntityLabelInSingular('小时统计新增用户')
            ->setEntityLabelInPlural('小时统计新增用户')
            ->setPageTitle('index', '小时统计新增用户管理')
            ->setPageTitle('detail', '小时统计新增用户详情')
            ->setPageTitle('edit', '编辑小时统计新增用户')
            ->setPageTitle('new', '新建小时统计新增用户')
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
