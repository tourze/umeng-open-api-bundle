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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use UmengOpenApiBundle\Entity\DailyDuration;

/**
 * 友盟应用使用时长统计管理控制器
 *
 * @extends AbstractCrudController<DailyDuration>
 */
#[AdminCrud(routePath: '/umeng/daily-duration', routeName: 'umeng_daily_duration')]
final class DailyDurationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DailyDuration::class;
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

            TextField::new('name', '时间区间')
                ->setRequired(true)
                ->setHelp('使用时长的时间区间单位（秒）')
                ->setMaxLength(255),

            IntegerField::new('value', '用户数/启动次数')
                ->setRequired(true)
                ->setHelp('在该时长区间内的启动次数或用户数'),

            NumberField::new('percent', '占比(%)')
                ->setRequired(false)
                ->setHelp('此区间时长占总时长的百分比')
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
            ->setEntityLabelInSingular('日统计使用时长')
            ->setEntityLabelInPlural('日统计使用时长')
            ->setPageTitle('index', '日统计使用时长管理')
            ->setPageTitle('detail', '日统计使用时长详情')
            ->setPageTitle('edit', '编辑日统计使用时长')
            ->setPageTitle('new', '新建日统计使用时长')
            ->setDefaultSort(['createTime' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('app')
            ->add('date')
            ->add('name')
            ->add('value')
            ->add('percent')
            ->add('createTime')
            ->add('updateTime')
        ;
    }
}
