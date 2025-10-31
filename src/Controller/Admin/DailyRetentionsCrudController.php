<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use UmengOpenApiBundle\Entity\DailyRetentions;

/**
 * 友盟日用户留存统计管理控制器
 *
 * @extends AbstractCrudController<DailyRetentions>
 */
#[AdminCrud(routePath: '/umeng/daily-retentions', routeName: 'umeng_daily_retentions')]
final class DailyRetentionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DailyRetentions::class;
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

            IntegerField::new('totalInstallUser', '当日安装用户数')
                ->setRequired(false)
                ->setHelp('当日的应用安装用户数量'),

            ArrayField::new('retentionRate', '用户留存率')
                ->setRequired(false)
                ->setHelp('相对之后几日的留存用户数，JSON格式存储'),

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
            ->setEntityLabelInSingular('日统计用户留存')
            ->setEntityLabelInPlural('日统计用户留存')
            ->setPageTitle('index', '日统计用户留存管理')
            ->setPageTitle('detail', '日统计用户留存详情')
            ->setPageTitle('edit', '编辑日统计用户留存')
            ->setPageTitle('new', '新建日统计用户留存')
            ->setDefaultSort(['createTime' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('app')
            ->add('date')
            ->add('totalInstallUser')
            ->add('createTime')
            ->add('updateTime')
        ;
    }
}
