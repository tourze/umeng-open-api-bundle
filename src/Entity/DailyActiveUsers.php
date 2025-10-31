<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use UmengOpenApiBundle\Repository\DailyActiveUsersRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getActiveUsers/1
 */
#[ORM\Entity(repositoryClass: DailyActiveUsersRepository::class)]
#[ORM\Table(name: 'ims_umeng_daily_active_users', options: ['comment' => '活跃用户数by天'])]
#[ORM\UniqueConstraint(name: 'ims_umeng_daily_active_users_idx_uniq', columns: ['app_id', 'date'])]
class DailyActiveUsers implements \Stringable
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

    #[Groups(groups: ['restful_read'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private App $app;

    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['comment' => '统计日期'])]
    #[Assert\NotNull]
    private ?\DateTimeInterface $date;

    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(options: ['comment' => '活跃用户数'])]
    #[Assert\PositiveOrZero]
    private int $value;

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

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
