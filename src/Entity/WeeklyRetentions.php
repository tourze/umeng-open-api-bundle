<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use UmengOpenApiBundle\Repository\WeeklyRetentionsRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getRetentions/1
 */
#[ORM\Entity(repositoryClass: WeeklyRetentionsRepository::class)]
#[ORM\Table(name: 'ims_umeng_weekly_retentions', options: ['comment' => 'App新增用户留存率by周'])]
#[ORM\UniqueConstraint(name: 'ims_umeng_weekly_retentions_idx_uniq', columns: ['app_id', 'date'])]
class WeeklyRetentions implements \Stringable
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

    #[ORM\ManyToOne(cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private App $app;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['comment' => '统计日期'])]
    #[Assert\NotNull]
    private ?\DateTimeInterface $date;

    #[ORM\Column(nullable: true, options: ['comment' => '当日安装用户数'])]
    #[Assert\PositiveOrZero]
    private ?int $totalInstallUser = null;

    #[ORM\Column(nullable: true, options: ['comment' => '相对之后几日的留存用户数'])]
    #[Assert\Range(min: 0, max: 100)]
    private ?float $retentionRate = null;

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

    public function getTotalInstallUser(): ?int
    {
        return $this->totalInstallUser;
    }

    public function setTotalInstallUser(?int $totalInstallUser): void
    {
        $this->totalInstallUser = $totalInstallUser;
    }

    public function getValue(): ?int
    {
        return $this->totalInstallUser;
    }

    public function setValue(?int $value): void
    {
        $this->totalInstallUser = $value;
    }

    public function getRetentionRate(): ?float
    {
        return $this->retentionRate;
    }

    public function setRetentionRate(?float $retentionRate): void
    {
        $this->retentionRate = $retentionRate;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
