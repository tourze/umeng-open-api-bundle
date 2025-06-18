<?php

namespace UmengOpenApiBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use UmengOpenApiBundle\Repository\ThirtyDayNewUsersRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getNewUsers/1
 */
#[ORM\Entity(repositoryClass: ThirtyDayNewUsersRepository::class)]
#[ORM\Table(name: 'ims_umeng_thirty_day_new_users', options: ['comment' => '新增用户数by30天'])]
#[ORM\UniqueConstraint(name: 'ims_umeng_thirty_day_new_users_idx_uniq', columns: ['app_id', 'date'])]
class ThirtyDayNewUsers implements Stringable
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

    #[ORM\Column]
    private ?int $value;

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

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
