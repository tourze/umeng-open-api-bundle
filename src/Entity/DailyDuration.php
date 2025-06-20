<?php

namespace UmengOpenApiBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use UmengOpenApiBundle\Repository\DailyDurationRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getDurations/1
 */
#[ORM\Entity(repositoryClass: DailyDurationRepository::class)]
#[ORM\Table(name: 'ims_umeng_daily_duration', options: ['comment' => 'App使用时长'])]
#[ORM\UniqueConstraint(name: 'ims_umeng_daily_duration_idx_uniq', columns: ['app_id', 'date', 'name'])]
class DailyDuration implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['comment' => 'ID'])]
    private ?int $id = 0;

    public function getId(): ?int
    {
        return $this->id;
    }
    use TimestampableAware;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private App $app;

#[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['comment' => '字段说明'])]
    private ?\DateTimeInterface $date;

    #[ORM\Column(options: ['comment' => '时间区间单位秒'])]
    private ?string $name;

    #[ORM\Column(options: ['comment' => '启动次数/用户数'])]
    private ?int $value;

    #[ORM\Column(options: ['comment' => '此区间的时长占'])]
    private ?float $percent;

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

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
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
