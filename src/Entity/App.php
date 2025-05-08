<?php

namespace UmengOpenApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Tourze\DoctrineIndexedBundle\Attribute\IndexColumn;
use Tourze\DoctrineSnowflakeBundle\Service\SnowflakeIdGenerator;
use Tourze\DoctrineTimestampBundle\Attribute\CreateTimeColumn;
use Tourze\DoctrineTimestampBundle\Attribute\UpdateTimeColumn;
use Tourze\EasyAdmin\Attribute\Action\Creatable;
use Tourze\EasyAdmin\Attribute\Action\Deletable;
use Tourze\EasyAdmin\Attribute\Action\Editable;
use Tourze\EasyAdmin\Attribute\Column\ExportColumn;
use Tourze\EasyAdmin\Attribute\Column\ListColumn;
use Tourze\EasyAdmin\Attribute\Filter\Filterable;
use Tourze\EasyAdmin\Attribute\Permission\AsPermission;
use UmengOpenApiBundle\Repository\AppRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getAppList/umeng.uapp.AppInfoData%5B%5D/1/2#contHeader
 */
#[AsPermission(title: '开放平台')]
#[Creatable]
#[Editable]
#[Deletable]
#[ORM\Entity(repositoryClass: AppRepository::class)]
#[ORM\Table(name: 'ims_umeng_open_api_app', options: ['comment' => '应用'])]
class App
{
    #[Filterable]
    #[IndexColumn]
    #[ListColumn(order: 98, sorter: true)]
    #[ExportColumn]
    #[CreateTimeColumn]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => '创建时间'])]
    private ?\DateTimeInterface $createTime = null;

    #[UpdateTimeColumn]
    #[ListColumn(order: 99, sorter: true)]
    #[Filterable]
    #[ExportColumn]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => '更新时间'])]
    private ?\DateTimeInterface $updateTime = null;

    public function setCreateTime(?\DateTimeInterface $createdAt): void
    {
        $this->createTime = $createdAt;
    }

    public function getCreateTime(): ?\DateTimeInterface
    {
        return $this->createTime;
    }

    public function setUpdateTime(?\DateTimeInterface $updateTime): void
    {
        $this->updateTime = $updateTime;
    }

    public function getUpdateTime(): ?\DateTimeInterface
    {
        return $this->updateTime;
    }

    #[ExportColumn]
    #[ListColumn(order: -1, sorter: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(SnowflakeIdGenerator::class)]
    #[ORM\Column(type: Types::BIGINT, nullable: false, options: ['comment' => 'ID'])]
    private ?string $id = null;

    #[ORM\Column(length: 100, options: ['comment' => 'App名称'])]
    private ?string $name = null;

    #[ORM\Column(length: 40, options: ['comment' => '应用ID'])]
    private ?string $appKey = null;

    /**
     * @var string|null iphone,android
     */
    #[ORM\Column(length: 20, options: ['comment' => '平台'])]
    private ?string $platform = null;

    #[ORM\Column(nullable: true, options: ['comment' => '是否关注'])]
    private ?bool $popular = null;

    #[ORM\Column(nullable: true, options: ['comment' => '是否为游戏'])]
    private ?bool $useGameSdk = null;

    #[ORM\ManyToOne(inversedBy: 'apps')]
    private Account $account;

    #[ORM\OneToMany(mappedBy: 'app', targetEntity: DailyData::class, orphanRemoval: true)]
    private Collection $dailyData;

    #[ORM\OneToMany(mappedBy: 'app', targetEntity: Channel::class, orphanRemoval: true)]
    private Collection $channels;

    public function __construct()
    {
        $this->dailyData = new ArrayCollection();
        $this->channels = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAppKey(): ?string
    {
        return $this->appKey;
    }

    public function setAppKey(string $appKey): static
    {
        $this->appKey = $appKey;

        return $this;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): static
    {
        $this->platform = $platform;

        return $this;
    }

    public function isPopular(): ?bool
    {
        return $this->popular;
    }

    public function setPopular(?bool $popular): static
    {
        $this->popular = $popular;

        return $this;
    }

    public function isUseGameSdk(): ?bool
    {
        return $this->useGameSdk;
    }

    public function setUseGameSdk(?bool $useGameSdk): static
    {
        $this->useGameSdk = $useGameSdk;

        return $this;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): static
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return Collection<int, DailyData>
     */
    public function getDailyData(): Collection
    {
        return $this->dailyData;
    }

    public function addDailyData(DailyData $dailyData): static
    {
        if (!$this->dailyData->contains($dailyData)) {
            $this->dailyData->add($dailyData);
            $dailyData->setApp($this);
        }

        return $this;
    }

    public function removeDailyData(DailyData $dailyData): static
    {
        if ($this->dailyData->removeElement($dailyData)) {
            // set the owning side to null (unless already changed)
            if ($dailyData->getApp() === $this) {
                $dailyData->setApp(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Channel>
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function addChannel(Channel $channel): static
    {
        if (!$this->channels->contains($channel)) {
            $this->channels->add($channel);
            $channel->setApp($this);
        }

        return $this;
    }

    public function removeChannel(Channel $channel): static
    {
        if ($this->channels->removeElement($channel)) {
            // set the owning side to null (unless already changed)
            if ($channel->getApp() === $this) {
                $channel->setApp(null);
            }
        }

        return $this;
    }
}
