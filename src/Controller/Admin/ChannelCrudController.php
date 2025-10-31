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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use UmengOpenApiBundle\Entity\Channel;

/**
 * 友盟应用渠道管理控制器
 *
 * @extends AbstractCrudController<Channel>
 */
#[AdminCrud(routePath: '/umeng/channel', routeName: 'umeng_channel')]
final class ChannelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Channel::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),

            TextField::new('code', '渠道代码')
                ->setRequired(true)
                ->setHelp('友盟渠道的唯一标识代码，自动生成')
                ->setMaxLength(10)
                ->hideOnForm(), // 自动生成，不允许手动编辑

            TextField::new('name', '渠道名称')
                ->setRequired(true)
                ->setHelp('渠道的描述性名称')
                ->setMaxLength(60),

            AssociationField::new('app', '关联应用')
                ->setRequired(true)
                ->setHelp('该渠道所属的应用'),

            AssociationField::new('dailyData', '日数据统计')
                ->setRequired(false)
                ->setHelp('该渠道的日统计数据记录')
                ->hideOnForm(),

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
            ->setEntityLabelInSingular('友盟渠道')
            ->setEntityLabelInPlural('友盟渠道')
            ->setPageTitle('index', '友盟渠道管理')
            ->setPageTitle('detail', '友盟渠道详情')
            ->setPageTitle('edit', '编辑友盟渠道')
            ->setPageTitle('new', '新建友盟渠道')
            ->setDefaultSort(['createTime' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('code')
            ->add('name')
            ->add('app')
            ->add('createTime')
            ->add('updateTime')
        ;
    }
}
