<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use UmengOpenApiBundle\Repository\DailyChannelDataRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getChannelData/1
 */
#[ORM\Entity(repositoryClass: DailyChannelDataRepository::class)]
#[ORM\Table(name: 'ims_umeng_daily_channel_data', options: ['comment' => '渠道维度日统计'])]
#[ORM\UniqueConstraint(name: 'ims_umeng_daily_channel_data_idx_uniq', columns: ['channel_id', 'date'])]
class DailyChannelData implements \Stringable
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
    private ?Channel $channel = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['comment' => '日期'])]
    #[Assert\NotNull]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(nullable: true, options: ['comment' => '启动数'])]
    #[Assert\PositiveOrZero]
    private ?int $launch = null;

    #[ORM\Column(length: 10, nullable: true, options: ['comment' => '使用时长(秒)'])]
    #[Assert\Length(max: 10)]
    #[Assert\Regex(pattern: '/^\d+$/', message: '使用时长必须是数字')]
    private ?string $duration = null;

    #[ORM\Column(nullable: true, options: ['comment' => '当前渠道总用户数在总用户数中的比例'])]
    #[Assert\Range(min: 0, max: 100)]
    #[Assert\PositiveOrZero]
    private ?float $totalUserRate = null;

    #[ORM\Column(nullable: true, options: ['comment' => '活跃用户'])]
    #[Assert\PositiveOrZero]
    private ?int $activeUser = null;

    #[ORM\Column(nullable: true, options: ['comment' => '新增用户'])]
    #[Assert\PositiveOrZero]
    private ?int $newUser = null;

    #[ORM\Column(nullable: true, options: ['comment' => '总用户数'])]
    #[Assert\PositiveOrZero]
    private ?int $totalUser = null;

    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    public function setChannel(?Channel $channel): void
    {
        $this->channel = $channel;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    public function getLaunch(): ?int
    {
        return $this->launch;
    }

    public function setLaunch(?int $launch): void
    {
        $this->launch = $launch;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): void
    {
        $this->duration = $duration;
    }

    public function getTotalUserRate(): ?float
    {
        return $this->totalUserRate;
    }

    public function setTotalUserRate(?float $totalUserRate): void
    {
        $this->totalUserRate = $totalUserRate;
    }

    public function getActiveUser(): ?int
    {
        return $this->activeUser;
    }

    public function setActiveUser(?int $activeUser): void
    {
        $this->activeUser = $activeUser;
    }

    public function getNewUser(): ?int
    {
        return $this->newUser;
    }

    public function setNewUser(?int $newUser): void
    {
        $this->newUser = $newUser;
    }

    public function getTotalUser(): ?int
    {
        return $this->totalUser;
    }

    public function setTotalUser(?int $totalUser): void
    {
        $this->totalUser = $totalUser;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
