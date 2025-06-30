<?php

namespace UmengOpenApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait HourTrait
{
    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '0时数据'])]
    private ?int $hour0 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '1时数据'])]
    private ?int $hour1 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '2时数据'])]
    private ?int $hour2 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '3时数据'])]
    private ?int $hour3 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '4时数据'])]
    private ?int $hour4 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '5时数据'])]
    private ?int $hour5 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '6时数据'])]
    private ?int $hour6 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '7时数据'])]
    private ?int $hour7 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '8时数据'])]
    private ?int $hour8 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '9时数据'])]
    private ?int $hour9 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '10时数据'])]
    private ?int $hour10 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '11时数据'])]
    private ?int $hour11 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '12时数据'])]
    private ?int $hour12 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '13时数据'])]
    private ?int $hour13 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '14时数据'])]
    private ?int $hour14 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '15时数据'])]
    private ?int $hour15 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '16时数据'])]
    private ?int $hour16 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '17时数据'])]
    private ?int $hour17 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '18时数据'])]
    private ?int $hour18 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '19时数据'])]
    private ?int $hour19 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '20时数据'])]
    private ?int $hour20 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '21时数据'])]
    private ?int $hour21 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '22时数据'])]
    private ?int $hour22 = null;

    #[Groups(groups: ['restful_read'])]
#[ORM\Column(nullable: true, options: ['comment' => '23时数据'])]
    private ?int $hour23 = null;

    public function getHour0(): ?int
    {
        return $this->hour0;
    }

    public function setHour0(?int $hour0): static
    {
        $this->hour0 = $hour0;

        return $this;
    }

    public function getHour1(): ?int
    {
        return $this->hour1;
    }

    public function setHour1(?int $hour1): static
    {
        $this->hour1 = $hour1;

        return $this;
    }

    public function getHour2(): ?int
    {
        return $this->hour2;
    }

    public function setHour2(?int $hour2): static
    {
        $this->hour2 = $hour2;

        return $this;
    }

    public function getHour3(): ?int
    {
        return $this->hour3;
    }

    public function setHour3(?int $hour3): static
    {
        $this->hour3 = $hour3;

        return $this;
    }

    public function getHour4(): ?int
    {
        return $this->hour4;
    }

    public function setHour4(?int $hour4): static
    {
        $this->hour4 = $hour4;

        return $this;
    }

    public function getHour5(): ?int
    {
        return $this->hour5;
    }

    public function setHour5(?int $hour5): static
    {
        $this->hour5 = $hour5;

        return $this;
    }

    public function getHour6(): ?int
    {
        return $this->hour6;
    }

    public function setHour6(?int $hour6): static
    {
        $this->hour6 = $hour6;

        return $this;
    }

    public function getHour7(): ?int
    {
        return $this->hour7;
    }

    public function setHour7(?int $hour7): static
    {
        $this->hour7 = $hour7;

        return $this;
    }

    public function getHour8(): ?int
    {
        return $this->hour8;
    }

    public function setHour8(?int $hour8): static
    {
        $this->hour8 = $hour8;

        return $this;
    }

    public function getHour9(): ?int
    {
        return $this->hour9;
    }

    public function setHour9(?int $hour9): static
    {
        $this->hour9 = $hour9;

        return $this;
    }

    public function getHour10(): ?int
    {
        return $this->hour10;
    }

    public function setHour10(?int $hour10): static
    {
        $this->hour10 = $hour10;

        return $this;
    }

    public function getHour11(): ?int
    {
        return $this->hour11;
    }

    public function setHour11(?int $hour11): static
    {
        $this->hour11 = $hour11;

        return $this;
    }

    public function getHour12(): ?int
    {
        return $this->hour12;
    }

    public function setHour12(?int $hour12): static
    {
        $this->hour12 = $hour12;

        return $this;
    }

    public function getHour13(): ?int
    {
        return $this->hour13;
    }

    public function setHour13(?int $hour13): static
    {
        $this->hour13 = $hour13;

        return $this;
    }

    public function getHour14(): ?int
    {
        return $this->hour14;
    }

    public function setHour14(?int $hour14): static
    {
        $this->hour14 = $hour14;

        return $this;
    }

    public function getHour15(): ?int
    {
        return $this->hour15;
    }

    public function setHour15(?int $hour15): static
    {
        $this->hour15 = $hour15;

        return $this;
    }

    public function getHour16(): ?int
    {
        return $this->hour16;
    }

    public function setHour16(?int $hour16): static
    {
        $this->hour16 = $hour16;

        return $this;
    }

    public function getHour17(): ?int
    {
        return $this->hour17;
    }

    public function setHour17(?int $hour17): static
    {
        $this->hour17 = $hour17;

        return $this;
    }

    public function getHour18(): ?int
    {
        return $this->hour18;
    }

    public function setHour18(?int $hour18): static
    {
        $this->hour18 = $hour18;

        return $this;
    }

    public function getHour19(): ?int
    {
        return $this->hour19;
    }

    public function setHour19(?int $hour19): static
    {
        $this->hour19 = $hour19;

        return $this;
    }

    public function getHour20(): ?int
    {
        return $this->hour20;
    }

    public function setHour20(?int $hour20): static
    {
        $this->hour20 = $hour20;

        return $this;
    }

    public function getHour21(): ?int
    {
        return $this->hour21;
    }

    public function setHour21(?int $hour21): static
    {
        $this->hour21 = $hour21;

        return $this;
    }

    public function getHour22(): ?int
    {
        return $this->hour22;
    }

    public function setHour22(?int $hour22): static
    {
        $this->hour22 = $hour22;

        return $this;
    }

    public function getHour23(): ?int
    {
        return $this->hour23;
    }

    public function setHour23(?int $hour23): static
    {
        $this->hour23 = $hour23;

        return $this;
    }
}
