<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use UmengOpenApiBundle\Repository\DailyDataRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getDailyData/umeng.uapp.DailyDataInfo/1/2#contHeader
 */
#[ORM\Entity(repositoryClass: DailyDataRepository::class)]
#[ORM\Table(name: 'ims_umeng_daily_data', options: ['comment' => 'App日统计数据'])]
#[ORM\UniqueConstraint(name: 'ims_umeng_daily_data_idx_uniq', columns: ['app_id', 'date'])]
class DailyData implements \Stringable
{
    use TimestampableAware;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['comment' => 'ID'])]
    private int $id = 0;

    public function getId(): int
    {
        return $this->id;
    }

    #[ORM\ManyToOne(inversedBy: 'dailyData')]
    #[ORM\JoinColumn(nullable: false)]
    private App $app;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['comment' => '统计日期'])]
    #[Assert\NotNull]
    private ?\DateTimeInterface $date;

    #[ORM\Column(nullable: true, options: ['comment' => '活跃用户数'])]
    #[Assert\PositiveOrZero]
    private ?int $activityUsers = null;

    #[ORM\Column(nullable: true, options: ['comment' => '总用户数'])]
    #[Assert\PositiveOrZero]
    private ?int $totalUsers = null;

    #[ORM\Column(nullable: true, options: ['comment' => '启动数'])]
    #[Assert\PositiveOrZero]
    private ?int $launches = null;

    #[ORM\Column(nullable: true, options: ['comment' => '新增用户数'])]
    #[Assert\PositiveOrZero]
    private ?int $newUsers = null;

    #[ORM\Column(nullable: true, options: ['comment' => '游戏付费用户数（仅游戏sdk）'])]
    #[Assert\PositiveOrZero]
    private ?int $payUsers = null;

    public function getApp(): App
    {
        return $this->app;
    }

    public function setApp(App $app): void
    {
        $this->app = $app;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    public function getActivityUsers(): ?int
    {
        return $this->activityUsers;
    }

    public function setActivityUsers(?int $activityUsers): void
    {
        $this->activityUsers = $activityUsers;
    }

    public function getTotalUsers(): ?int
    {
        return $this->totalUsers;
    }

    public function setTotalUsers(?int $totalUsers): void
    {
        $this->totalUsers = $totalUsers;
    }

    public function getLaunches(): ?int
    {
        return $this->launches;
    }

    public function setLaunches(?int $launches): void
    {
        $this->launches = $launches;
    }

    public function getNewUsers(): ?int
    {
        return $this->newUsers;
    }

    public function setNewUsers(?int $newUsers): void
    {
        $this->newUsers = $newUsers;
    }

    public function getPayUsers(): ?int
    {
        return $this->payUsers;
    }

    public function setPayUsers(?int $payUsers): void
    {
        $this->payUsers = $payUsers;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
