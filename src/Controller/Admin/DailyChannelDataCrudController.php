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
use UmengOpenApiBundle\Entity\DailyChannelData;

/**
 * 友盟渠道日统计数据管理控制器
 *
 * @extends AbstractCrudController<DailyChannelData>
 */
#[AdminCrud(routePath: '/umeng/daily-channel-data', routeName: 'umeng_daily_channel_data')]
final class DailyChannelDataCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DailyChannelData::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),

            AssociationField::new('channel', '关联渠道')
                ->setRequired(true)
                ->setHelp('统计数据所属的渠道'),

            DateTimeField::new('date', '统计日期')
                ->setRequired(true)
                ->setHelp('统计数据的日期')
                ->setFormat('yyyy-MM-dd'),

            IntegerField::new('launch', '启动数')
                ->setRequired(false)
                ->setHelp('当日渠道的启动次数'),

            TextField::new('duration', '使用时长(秒)')
                ->setRequired(false)
                ->setHelp('当日渠道的使用时长，单位为秒')
                ->setMaxLength(10),

            NumberField::new('totalUserRate', '总用户数比例(%)')
                ->setRequired(false)
                ->setHelp('当前渠道总用户数在总用户数中的比例')
                ->setNumDecimals(2),

            IntegerField::new('activeUser', '活跃用户数')
                ->setRequired(false)
                ->setHelp('当日渠道的活跃用户数'),

            IntegerField::new('newUser', '新增用户数')
                ->setRequired(false)
                ->setHelp('当日渠道的新增用户数'),

            IntegerField::new('totalUser', '总用户数')
                ->setRequired(false)
                ->setHelp('当日渠道的总用户数'),

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
            ->setEntityLabelInSingular('日统计渠道数据')
            ->setEntityLabelInPlural('日统计渠道数据')
            ->setPageTitle('index', '日统计渠道数据管理')
            ->setPageTitle('detail', '日统计渠道数据详情')
            ->setPageTitle('edit', '编辑日统计渠道数据')
            ->setPageTitle('new', '新建日统计渠道数据')
            ->setDefaultSort(['createTime' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('channel')
            ->add('date')
            ->add('launch')
            ->add('activeUser')
            ->add('newUser')
            ->add('totalUser')
            ->add('createTime')
            ->add('updateTime')
        ;
    }
}
