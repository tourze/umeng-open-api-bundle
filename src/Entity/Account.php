<?php

namespace UmengOpenApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\Serializer\Attribute\Ignore;
use Tourze\DoctrineSnowflakeBundle\Service\SnowflakeIdGenerator;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use Tourze\DoctrineTrackBundle\Attribute\TrackColumn;
use Tourze\DoctrineUserBundle\Traits\BlameableAware;
use UmengOpenApiBundle\Repository\AccountRepository;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
#[ORM\Table(name: 'ims_umeng_open_api_account', options: ['comment' => '开放平台'])]
class Account implements Stringable
{
    use TimestampableAware;
    use BlameableAware;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(SnowflakeIdGenerator::class)]
    #[ORM\Column(type: Types::BIGINT, nullable: false, options: ['comment' => 'ID'])]
    private ?string $id = null;

    #[TrackColumn]
    private ?bool $valid = false;

    #[ORM\Column(length: 100, options: ['comment' => '账户名称'])]
    private ?string $name = null;

    #[ORM\Column(length: 40, options: ['comment' => 'API密钥'])]
    private ?string $apiKey = null;

    #[ORM\Column(length: 40, options: ['comment' => 'API安全密钥'])]
    private ?string $apiSecurity = null;

    #[Ignore]
    #[ORM\OneToMany(mappedBy: 'account', targetEntity: App::class)]
    private Collection $apps;

    public function __construct()
    {
        $this->apps = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(?bool $valid): self
    {
        $this->valid = $valid;

        return $this;
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

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): static
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getApiSecurity(): ?string
    {
        return $this->apiSecurity;
    }

    public function setApiSecurity(string $apiSecurity): static
    {
        $this->apiSecurity = $apiSecurity;

        return $this;
    }

    /**
     * @return Collection<int, App>
     */
    public function getApps(): Collection
    {
        return $this->apps;
    }

    public function addApp(App $app): static
    {
        if (!$this->apps->contains($app)) {
            $this->apps->add($app);
            $app->setAccount($this);
        }

        return $this;
    }

    public function removeApp(App $app): static
    {
        if ($this->apps->removeElement($app)) {
            // set the owning side to null (unless already changed)
            if ($app->getAccount() === $this) {
                $app->setAccount(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
