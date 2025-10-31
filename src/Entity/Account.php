<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use Tourze\DoctrineTrackBundle\Attribute\TrackColumn;
use Tourze\DoctrineUserBundle\Traits\BlameableAware;
use UmengOpenApiBundle\Repository\AccountRepository;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
#[ORM\Table(name: 'ims_umeng_open_api_account', options: ['comment' => '开放平台'])]
class Account implements \Stringable
{
    use TimestampableAware;
    use BlameableAware;
    use SnowflakeKeyAware;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false, 'comment' => '是否有效'])]
    #[TrackColumn]
    #[Assert\Type(type: 'bool')]
    #[Assert\NotNull]
    private ?bool $valid = false;

    #[ORM\Column(length: 100, options: ['comment' => '账户名称'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 40, options: ['comment' => 'API密钥'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    private ?string $apiKey = null;

    #[ORM\Column(length: 40, options: ['comment' => 'API安全密钥'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    private ?string $apiSecurity = null;

    /**
     * @var Collection<int, App>
     */
    #[Ignore]
    #[ORM\OneToMany(mappedBy: 'account', targetEntity: App::class)]
    private Collection $apps;

    public function __construct()
    {
        $this->apps = new ArrayCollection();
    }

    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(?bool $valid): void
    {
        $this->valid = $valid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    public function getApiSecurity(): ?string
    {
        return $this->apiSecurity;
    }

    public function setApiSecurity(string $apiSecurity): void
    {
        $this->apiSecurity = $apiSecurity;
    }

    /**
     * @return Collection<int, App>
     */
    public function getApps(): Collection
    {
        return $this->apps;
    }

    /**
     * @param Collection<int, App> $apps
     */
    public function setApps(Collection $apps): void
    {
        $this->apps = $apps;
    }

    public function addApp(App $app): void
    {
        if (!$this->apps->contains($app)) {
            $this->apps->add($app);
            $app->setAccount($this);
        }
    }

    public function removeApp(App $app): void
    {
        if ($this->apps->removeElement($app)) {
            // set the owning side to null (unless already changed)
            if ($app->getAccount() === $this) {
                $app->setAccount(null);
            }
        }
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
