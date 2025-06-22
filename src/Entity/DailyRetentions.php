<?php

namespace UmengOpenApiBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use UmengOpenApiBundle\Repository\DailyRetentionsRepository;

/**
 * App新增用户留存率
 *
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getRetentions/1
 */
#[ORM\Entity(repositoryClass: DailyRetentionsRepository::class)]
#[ORM\Table(name: 'ims_umeng_daily_retentions', options: ['comment' => 'App新增用户留存率by天'])]
#[ORM\UniqueConstraint(name: 'ims_umeng_daily_retentions_idx_uniq', columns: ['app_id', 'date'])]
class DailyRetentions implements Stringable
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

#[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['comment' => '统计日期'])]
    private \DateTimeInterface $date;

    #[ORM\Column(nullable: true, options: ['comment' => '当日安装用户数'])]
    private ?int $totalInstallUser = null;

    #[ORM\Column(nullable: true, options: ['comment' => '相对之后几日的留存用户数'], type: Types::JSON)]
    private ?array $retentionRate = null;

    public function getRetentionRate(): ?array
    {
        return $this->retentionRate;
    }

    public function setRetentionRate(?array $retentionRate): void
    {
        $this->retentionRate = $retentionRate;
    }

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

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
