<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use UmengOpenApiBundle\Repository\DailyPerLaunchDurationRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getDurations/1
 */
#[ORM\Entity(repositoryClass: DailyPerLaunchDurationRepository::class)]
#[ORM\Table(name: 'ims_umeng_daily_per_launch_duration', options: ['comment' => 'App使用时长'])]
#[ORM\UniqueConstraint(name: 'ims_umeng_daily_per_launch_duration_idx_uniq', columns: ['app_id', 'date', 'name'])]
class DailyPerLaunchDuration implements \Stringable
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

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private App $app;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['comment' => '统计日期'])]
    #[Assert\NotNull]
    private ?\DateTimeInterface $date;

    #[ORM\Column(options: ['comment' => '时间区间单位秒'])]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column(options: ['comment' => '启动次数/用户数'])]
    #[Assert\PositiveOrZero]
    private int $value = 0;

    #[ORM\Column(options: ['comment' => '此区间的时长占'])]
    #[Assert\Range(min: 0, max: 100)]
    private ?float $percent = null;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function getPercent(): ?float
    {
        return $this->percent;
    }

    public function setPercent(?float $percent): void
    {
        $this->percent = $percent;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
