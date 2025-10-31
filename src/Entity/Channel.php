<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineRandomBundle\Attribute\RandomStringColumn;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use UmengOpenApiBundle\Repository\ChannelRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getChannelData/umeng.uapp.ChannelInfo%5B%5D/1/2#contHeader
 */
#[ORM\Entity(repositoryClass: ChannelRepository::class)]
#[ORM\Table(name: 'ims_umeng_channel', options: ['comment' => 'APP渠道信息'])]
class Channel implements \Stringable
{
    use TimestampableAware;
    use SnowflakeKeyAware;

    #[ORM\Column(length: 10, unique: true, options: ['comment' => '渠道代码'])]
    #[RandomStringColumn(length: 10)]
    #[Groups(groups: ['admin_curd'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 10)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'channels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?App $app = null;

    #[ORM\Column(length: 60, options: ['comment' => '字段说明'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 60)]
    private string $name;

    /**
     * @var Collection<int, DailyChannelData>
     */
    #[Ignore]
    #[ORM\OneToMany(targetEntity: DailyChannelData::class, mappedBy: 'channel', orphanRemoval: true)]
    private Collection $dailyData;

    public function __construct()
    {
        $this->dailyData = new ArrayCollection();
    }

    public function getApp(): ?App
    {
        return $this->app;
    }

    public function setApp(?App $app): void
    {
        $this->app = $app;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return Collection<int, DailyChannelData>
     */
    public function getDailyData(): Collection
    {
        return $this->dailyData;
    }

    public function addDailyData(DailyChannelData $dailyData): void
    {
        if (!$this->dailyData->contains($dailyData)) {
            $this->dailyData->add($dailyData);
            $dailyData->setChannel($this);
        }
    }

    public function removeDailyData(DailyChannelData $dailyData): void
    {
        if ($this->dailyData->removeElement($dailyData)) {
            // set the owning side to null (unless already changed)
            if ($dailyData->getChannel() === $this) {
                $dailyData->setChannel(null);
            }
        }
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
