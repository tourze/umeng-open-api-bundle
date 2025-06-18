<?php

namespace UmengOpenApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
use Tourze\DoctrineRandomBundle\Attribute\RandomStringColumn;
use Tourze\DoctrineSnowflakeBundle\Service\SnowflakeIdGenerator;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use Tourze\EasyAdmin\Attribute\Column\ExportColumn;
use Tourze\EasyAdmin\Attribute\Column\ListColumn;
use Tourze\EasyAdmin\Attribute\Field\FormField;
use Tourze\EasyAdmin\Attribute\Filter\Keyword;
use UmengOpenApiBundle\Repository\ChannelRepository;

/**
 * @see https://developer.umeng.com/open-api/docs/com.umeng.uapp/umeng.uapp.getChannelData/umeng.uapp.ChannelInfo%5B%5D/1/2#contHeader
 */
#[ORM\Entity(repositoryClass: ChannelRepository::class)]
#[ORM\Table(name: 'ims_umeng_channel', options: ['comment' => 'APP渠道信息'])]
class Channel
{
    use TimestampableAware;
    #[ExportColumn]
    #[ListColumn(order: -1, sorter: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(SnowflakeIdGenerator::class)]
    #[ORM\Column(type: Types::BIGINT, nullable: false, options: ['comment' => 'ID'])]
    private ?string $id = null;

    #[RandomStringColumn(length: 10)]
    #[Groups(['admin_curd'])]
    #[FormField(title: '编码', order: -1)]
    #[Keyword]
    #[ListColumn(order: -1)]
    #[ORM\Column(type: Types::STRING, length: 100, unique: true, nullable: true, options: ['comment' => '编码'])]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'channels')]
    #[ORM\JoinColumn(nullable: false)]
    private App $app;

    #[ORM\Column(length: 60)]
    private string $name;

    #[Ignore]
    #[ORM\OneToMany(targetEntity: DailyChannelData::class, mappedBy: 'channel', orphanRemoval: true)]
    private Collection $dailyData;

    public function __construct()
    {
        $this->dailyData = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
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
    }}
