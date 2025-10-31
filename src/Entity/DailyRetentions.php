<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
class DailyRetentions implements \Stringable
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

    #[ORM\Column(nullable: true, options: ['comment' => '当日安装用户数'])]
    #[Assert\PositiveOrZero]
    private ?int $totalInstallUser = null;

    /**
     * @var array<int|string, int|float>|null
     */
    #[ORM\Column(type: Types::JSON, nullable: true, options: ['comment' => '相对之后几日的留存用户数'])]
    #[Assert\Type(type: 'array')]
    private ?array $retentionRate = null;

    /** @return array<int|string, int|float>|null */
    public function getRetentionRate(): ?array
    {
        return $this->retentionRate;
    }

    /** @param array<int|string, int|float>|null $retentionRate */
    public function setRetentionRate(?array $retentionRate): void
    {
        $this->retentionRate = $retentionRate;
    }

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

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
