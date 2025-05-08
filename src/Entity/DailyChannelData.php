<?php

namespace UmengOpenApiBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use UmengOpenApiBundle\Repository\DailyChannelDataRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getChannelData/1
 */
#[ORM\Entity(repositoryClass: DailyChannelDataRepository::class)]
#[ORM\Table(name: 'ims_umeng_daily_channel_data', options: ['comment' => '渠道维度日统计'])]
#[ORM\UniqueConstraint(name: 'ims_umeng_daily_channel_data_idx_uniq', columns: ['channel_id', 'date'])]
class DailyChannelData
{
    #[ListColumn(order: -1)]
    #[ExportColumn]
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
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => '创建时间'])]
    private ?\DateTimeInterface $createTime = null;

    #[UpdateTimeColumn]
    #[ListColumn(order: 99, sorter: true)]
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
    private Channel $channel;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['comment' => '日期'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(nullable: true, options: ['comment' => '启动数'])]
    private ?int $launch = null;

    #[ORM\Column(length: 10, nullable: true, options: ['comment' => '使用时长(秒)'])]
    private ?int $duration = null;

    #[ORM\Column(nullable: true, options: ['comment' => '当前渠道总用户数在总用户数中的比例'])]
    private ?float $totalUserRate = null;

    #[ORM\Column(nullable: true, options: ['comment' => '活跃用户'])]
    private ?int $activeUser = null;

    #[ORM\Column(nullable: true, options: ['comment' => '新增用户'])]
    private ?int $newUser = null;

    #[ORM\Column(nullable: true, options: ['comment' => '总用户数'])]
    private ?int $totalUser = null;

    public function getChannel(): Channel
    {
        return $this->channel;
    }

    public function setChannel(Channel $channel): static
    {
        $this->channel = $channel;

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

    public function getLaunch(): ?int
    {
        return $this->launch;
    }

    public function setLaunch(?int $launch): static
    {
        $this->launch = $launch;

        return $this;
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getTotalUserRate(): ?float
    {
        return $this->totalUserRate;
    }

    public function setTotalUserRate(?float $totalUserRate): static
    {
        $this->totalUserRate = $totalUserRate;

        return $this;
    }

    public function getActiveUser(): ?int
    {
        return $this->activeUser;
    }

    public function setActiveUser(?int $activeUser): static
    {
        $this->activeUser = $activeUser;

        return $this;
    }

    public function getNewUser(): ?int
    {
        return $this->newUser;
    }

    public function setNewUser(?int $newUser): static
    {
        $this->newUser = $newUser;

        return $this;
    }

    public function getTotalUser(): ?int
    {
        return $this->totalUser;
    }

    public function setTotalUser(?int $totalUser): static
    {
        $this->totalUser = $totalUser;

        return $this;
    }
}
