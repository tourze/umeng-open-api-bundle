<?php

namespace UmengOpenApiBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use UmengOpenApiBundle\Repository\MonthlyRetentionsRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getRetentions/1
 */
#[ORM\Entity(repositoryClass: MonthlyRetentionsRepository::class)]
#[ORM\Table(name: 'ims_umeng_monthly_retentions', options: ['comment' => 'App新增用户留存率by月'])]
#[ORM\UniqueConstraint(name: 'ims_umeng_monthly_retentions_idx_uniq', columns: ['app_id', 'date'])]
class MonthlyRetentions implements Stringable
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

    #[ORM\Column(nullable: true, options: ['comment' => '当日安装用户数'])]
    private ?int $totalInstallUser = null;

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

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
