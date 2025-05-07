<?php

namespace UmengOpenApiBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use UmengOpenApiBundle\Repository\DailyDataRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getDailyData/umeng.uapp.DailyDataInfo/1/2#contHeader
 */
#[ORM\Entity(repositoryClass: DailyDataRepository::class)]
#[ORM\Table(name: 'ims_umeng_daily_data', options: ['comment' => 'App日统计数据'])]
#[ORM\UniqueConstraint(name: 'ims_umeng_daily_data_idx_uniq', columns: ['app_id', 'date'])]
class DailyData
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

    #[ORM\ManyToOne(inversedBy: 'dailyData')]
    #[ORM\JoinColumn(nullable: false)]
    private App $app;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['comment' => '统计日期'])]
    private ?\DateTimeInterface $date;

    #[ORM\Column(nullable: true, options: ['comment' => '活跃用户数'])]
    private ?int $activityUsers = null;

    #[ORM\Column(nullable: true, options: ['comment' => '总用户数'])]
    private ?int $totalUsers = null;

    #[ORM\Column(nullable: true, options: ['comment' => '启动数'])]
    private ?int $launches = null;

    #[ORM\Column(nullable: true, options: ['comment' => '新增用户数'])]
    private ?int $newUsers = null;

    #[ORM\Column(nullable: true, options: ['comment' => '游戏付费用户数（仅游戏sdk）'])]
    private ?int $payUsers = null;

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

    public function getActivityUsers(): ?int
    {
        return $this->activityUsers;
    }

    public function setActivityUsers(?int $activityUsers): static
    {
        $this->activityUsers = $activityUsers;

        return $this;
    }

    public function getTotalUsers(): ?int
    {
        return $this->totalUsers;
    }

    public function setTotalUsers(?int $totalUsers): static
    {
        $this->totalUsers = $totalUsers;

        return $this;
    }

    public function getLaunches(): ?int
    {
        return $this->launches;
    }

    public function setLaunches(?int $launches): static
    {
        $this->launches = $launches;

        return $this;
    }

    public function getNewUsers(): ?int
    {
        return $this->newUsers;
    }

    public function setNewUsers(?int $newUsers): static
    {
        $this->newUsers = $newUsers;

        return $this;
    }

    public function getPayUsers(): ?int
    {
        return $this->payUsers;
    }

    public function setPayUsers(?int $payUsers): static
    {
        $this->payUsers = $payUsers;

        return $this;
    }
}
