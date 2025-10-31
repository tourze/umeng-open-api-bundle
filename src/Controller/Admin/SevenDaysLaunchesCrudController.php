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
use UmengOpenApiBundle\Entity\SevenDaysLaunches;

/**
 * 友盟7天启动次数统计管理控制器
 *
 * @extends AbstractCrudController<SevenDaysLaunches>
 */
#[AdminCrud(routePath: '/umeng/seven-days-launches', routeName: 'umeng_seven_days_launches')]
final class SevenDaysLaunchesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SevenDaysLaunches::class;
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

            IntegerField::new('value', '7天启动次数')
                ->setRequired(true)
                ->setHelp('过去7天的应用启动次数'),

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
            ->setEntityLabelInSingular('7天统计启动次数')
            ->setEntityLabelInPlural('7天统计启动次数')
            ->setPageTitle('index', '7天统计启动次数管理')
            ->setPageTitle('detail', '7天统计启动次数详情')
            ->setPageTitle('edit', '编辑7天统计启动次数')
            ->setPageTitle('new', '新建7天统计启动次数')
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
