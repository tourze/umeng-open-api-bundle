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
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use UmengOpenApiBundle\Entity\WeeklyRetentions;

/**
 * 友盟周用户留存统计管理控制器
 *
 * @extends AbstractCrudController<WeeklyRetentions>
 */
#[AdminCrud(routePath: '/umeng/weekly-retentions', routeName: 'umeng_weekly_retentions')]
final class WeeklyRetentionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WeeklyRetentions::class;
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

            IntegerField::new('totalInstallUser', '当周安装用户数')
                ->setRequired(false)
                ->setHelp('当周的应用安装用户数量'),

            NumberField::new('retentionRate', '用户留存率(%)')
                ->setRequired(false)
                ->setHelp('相对之后时期的留存用户比率')
                ->setNumDecimals(2),

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
            ->setEntityLabelInSingular('周统计用户留存')
            ->setEntityLabelInPlural('周统计用户留存')
            ->setPageTitle('index', '周统计用户留存管理')
            ->setPageTitle('detail', '周统计用户留存详情')
            ->setPageTitle('edit', '编辑周统计用户留存')
            ->setPageTitle('new', '新建周统计用户留存')
            ->setDefaultSort(['createTime' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add('app')
            ->add('date')
            ->add('totalInstallUser')
            ->add('retentionRate')
            ->add('createTime')
            ->add('updateTime')
        ;
    }
}
