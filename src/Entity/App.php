<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use UmengOpenApiBundle\Repository\AppRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getAppList/umeng.uapp.AppInfoData%5B%5D/1/2#contHeader
 */
#[ORM\Entity(repositoryClass: AppRepository::class)]
#[ORM\Table(name: 'ims_umeng_open_api_app', options: ['comment' => '应用'])]
class App implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;

    #[ORM\Column(length: 100, options: ['comment' => 'App名称'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 40, options: ['comment' => '应用ID'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    private ?string $appKey = null;

    #[ORM\Column(length: 20, options: ['comment' => '平台'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 20)]
    private ?string $platform = null;

    #[ORM\Column(nullable: true, options: ['comment' => '是否关注'])]
    #[Assert\Type(type: 'bool')]
    private ?bool $popular = null;

    #[ORM\Column(nullable: true, options: ['comment' => '是否为游戏'])]
    #[Assert\Type(type: 'bool')]
    private ?bool $useGameSdk = null;

    #[ORM\ManyToOne(inversedBy: 'apps')]
    private ?Account $account = null;

    /** @var Collection<int, DailyData> */
    #[ORM\OneToMany(mappedBy: 'app', targetEntity: DailyData::class, orphanRemoval: true)]
    private Collection $dailyData;

    /** @var Collection<int, Channel> */
    #[ORM\OneToMany(mappedBy: 'app', targetEntity: Channel::class, orphanRemoval: true)]
    private Collection $channels;

    public function __construct()
    {
        $this->dailyData = new ArrayCollection();
        $this->channels = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAppKey(): ?string
    {
        return $this->appKey;
    }

    public function setAppKey(string $appKey): void
    {
        $this->appKey = $appKey;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): void
    {
        $this->platform = $platform;
    }

    public function isPopular(): ?bool
    {
        return $this->popular;
    }

    public function setPopular(?bool $popular): void
    {
        $this->popular = $popular;
    }

    public function isUseGameSdk(): ?bool
    {
        return $this->useGameSdk;
    }

    public function setUseGameSdk(?bool $useGameSdk): void
    {
        $this->useGameSdk = $useGameSdk;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): void
    {
        $this->account = $account;
    }

    /**
     * @return Collection<int, DailyData>
     */
    public function getDailyData(): Collection
    {
        return $this->dailyData;
    }

    public function addDailyData(DailyData $dailyData): void
    {
        if (!$this->dailyData->contains($dailyData)) {
            $this->dailyData->add($dailyData);
            $dailyData->setApp($this);
        }
    }

    public function removeDailyData(DailyData $dailyData): void
    {
        $this->dailyData->removeElement($dailyData);
    }

    /**
     * @return Collection<int, Channel>
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function addChannel(Channel $channel): void
    {
        if (!$this->channels->contains($channel)) {
            $this->channels->add($channel);
            $channel->setApp($this);
        }
    }

    public function removeChannel(Channel $channel): void
    {
        $this->channels->removeElement($channel);
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
