<?php

namespace UmengOpenApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
use Tourze\DoctrineRandomBundle\Attribute\RandomStringColumn;
use Tourze\DoctrineSnowflakeBundle\Service\SnowflakeIdGenerator;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use UmengOpenApiBundle\Repository\ChannelRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getChannelData/umeng.uapp.ChannelInfo%5B%5D/1/2#contHeader
 */
#[ORM\Entity(repositoryClass: ChannelRepository::class)]
#[ORM\Table(name: 'ims_umeng_channel', options: ['comment' => 'APP渠道信息'])]
class Channel implements Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;

    #[RandomStringColumn(length: 10)]
    #[Groups(groups: ['admin_curd'])]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'channels')]
    #[ORM\JoinColumn(nullable: false)]
    private App $app;

    #[ORM\Column(length: 60, options: ['comment' => '字段说明'])]
    private string $name;

    #[Ignore]
    #[ORM\OneToMany(targetEntity: DailyChannelData::class, mappedBy: 'channel', orphanRemoval: true)]
    private Collection $dailyData;

    public function __construct()
    {
        $this->dailyData = new ArrayCollection();
    }


    public function getApp(): App
    {
        return $this->app;
    }

    public function setApp(?App $app): static
    {
        $this->app = $app;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, DailyChannelData>
     */
    public function getDailyData(): Collection
    {
        return $this->dailyData;
    }

    public function addDailyData(DailyChannelData $dailyData): static
    {
        if (!$this->dailyData->contains($dailyData)) {
            $this->dailyData->add($dailyData);
            $dailyData->setChannel($this);
        }

        return $this;
    }

    public function removeDailyData(DailyChannelData $dailyData): static
    {
        if ($this->dailyData->removeElement($dailyData)) {
            // set the owning side to null (unless already changed)
            if ($dailyData->getChannel() === $this) {
                $dailyData->setChannel(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return (string) $this->id;
    }
}
