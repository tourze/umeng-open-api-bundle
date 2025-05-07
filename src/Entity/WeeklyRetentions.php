<?php

namespace UmengOpenApiBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use UmengOpenApiBundle\Repository\WeeklyRetentionsRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getRetentions/1
 */
#[ORM\Entity(repositoryClass: WeeklyRetentionsRepository::class)]
#[ORM\Table(name: 'ims_umeng_weekly_retentions', options: ['comment' => 'App新增用户留存率by周'])]
#[ORM\UniqueConstraint(name: 'ims_umeng_weekly_retentions_idx_uniq', columns: ['app_id', 'date'])]
class WeeklyRetentions
{
    #[ListColumn(order: -1)]
    #[ExportColumn]
    #[Groups(['restful_read', 'api_tree', 'admin_curd', 'api_list'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['comment' => 'ID'])]
    private ?int $id = 0;

    public function getId(): ?int
    {
        return $this->id;
    }
    #[Filterable]
    #[IndexColumn]
    #[ListColumn(order: 98, sorter: true)]
    #[ExportColumn]
    #[CreateTimeColumn]
    #[Groups(['restful_read', 'admin_curd', 'restful_read'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => '创建时间'])]
    private ?\DateTimeInterface $createTime = null;

    #[UpdateTimeColumn]
    #[ListColumn(order: 99, sorter: true)]
    #[Groups(['restful_read', 'admin_curd', 'restful_read'])]
    #[Filterable]
    #[ExportColumn]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => '更新时间'])]
    private ?\DateTimeInterface $updateTime = null;

    public function setCreateTime(?\DateTimeInterface $createdAt): void
    {
        $this->createTime = $createdAt;
    }

    public function getCreateTime(): ?\DateTimeInterface
    {
        return $this->createTime;
    }

    public function setUpdateTime(?\DateTimeInterface $updateTime): void
    {
        $this->updateTime = $updateTime;
    }

    public function getUpdateTime(): ?\DateTimeInterface
    {
        return $this->updateTime;
    }

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private App $app;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date;

    #[ORM\Column(nullable: true, options: ['comment' => '当日安装用户数'])]
    private ?int $totalInstallUser = null;

    /**
     * @var float|null 安装日期到今日之间7天（每天），14天后，30天后留存用户占比（不包含今日）
     */
    #[ORM\Column(nullable: true, options: ['comment' => '相对之后几日的留存用户数'])]
    private ?float $retentionRate = null;

    public function getApp(): App
    {
        return $this->app;
    }

    public function setApp(App $app): static
    {
        $this->app = $app;

        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTotalInstallUser(): ?int
    {
        return $this->totalInstallUser;
    }

    public function setTotalInstallUser(?int $totalInstallUser): static
    {
        $this->totalInstallUser = $totalInstallUser;

        return $this;
    }

    public function getRetentionRate(): ?float
    {
        return $this->retentionRate;
    }

    public function setRetentionRate(?float $retentionRate): static
    {
        $this->retentionRate = $retentionRate;

        return $this;
    }
}
