<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait HourTrait
{
    /**
     * 0时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '0时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour0 = null;

    /**
     * 1时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '1时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour1 = null;

    /**
     * 2时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '2时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour2 = null;

    /**
     * 3时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '3时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour3 = null;

    /**
     * 4时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '4时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour4 = null;

    /**
     * 5时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '5时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour5 = null;

    /**
     * 6时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '6时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour6 = null;

    /**
     * 7时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '7时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour7 = null;

    /**
     * 8时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '8时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour8 = null;

    /**
     * 9时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '9时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour9 = null;

    /**
     * 10时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '10时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour10 = null;

    /**
     * 11时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '11时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour11 = null;

    /**
     * 12时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '12时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour12 = null;

    /**
     * 13时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '13时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour13 = null;

    /**
     * 14时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '14时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour14 = null;

    /**
     * 15时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '15时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour15 = null;

    /**
     * 16时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '16时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour16 = null;

    /**
     * 17时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '17时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour17 = null;

    /**
     * 18时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '18时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour18 = null;

    /**
     * 19时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '19时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour19 = null;

    /**
     * 20时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '20时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour20 = null;

    /**
     * 21时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '21时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour21 = null;

    /**
     * 22时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '22时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour22 = null;

    /**
     * 23时数据
     */
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(nullable: true, options: ['comment' => '23时数据'])]
    #[Assert\PositiveOrZero]
    private ?int $hour23 = null;

    public function getHour0(): ?int
    {
        return $this->hour0;
    }

    public function setHour0(?int $hour0): void
    {
        $this->hour0 = $hour0;
    }

    public function getHour1(): ?int
    {
        return $this->hour1;
    }

    public function setHour1(?int $hour1): void
    {
        $this->hour1 = $hour1;
    }

    public function getHour2(): ?int
    {
        return $this->hour2;
    }

    public function setHour2(?int $hour2): void
    {
        $this->hour2 = $hour2;
    }

    public function getHour3(): ?int
    {
        return $this->hour3;
    }

    public function setHour3(?int $hour3): void
    {
        $this->hour3 = $hour3;
    }

    public function getHour4(): ?int
    {
        return $this->hour4;
    }

    public function setHour4(?int $hour4): void
    {
        $this->hour4 = $hour4;
    }

    public function getHour5(): ?int
    {
        return $this->hour5;
    }

    public function setHour5(?int $hour5): void
    {
        $this->hour5 = $hour5;
    }

    public function getHour6(): ?int
    {
        return $this->hour6;
    }

    public function setHour6(?int $hour6): void
    {
        $this->hour6 = $hour6;
    }

    public function getHour7(): ?int
    {
        return $this->hour7;
    }

    public function setHour7(?int $hour7): void
    {
        $this->hour7 = $hour7;
    }

    public function getHour8(): ?int
    {
        return $this->hour8;
    }

    public function setHour8(?int $hour8): void
    {
        $this->hour8 = $hour8;
    }

    public function getHour9(): ?int
    {
        return $this->hour9;
    }

    public function setHour9(?int $hour9): void
    {
        $this->hour9 = $hour9;
    }

    public function getHour10(): ?int
    {
        return $this->hour10;
    }

    public function setHour10(?int $hour10): void
    {
        $this->hour10 = $hour10;
    }

    public function getHour11(): ?int
    {
        return $this->hour11;
    }

    public function setHour11(?int $hour11): void
    {
        $this->hour11 = $hour11;
    }

    public function getHour12(): ?int
    {
        return $this->hour12;
    }

    public function setHour12(?int $hour12): void
    {
        $this->hour12 = $hour12;
    }

    public function getHour13(): ?int
    {
        return $this->hour13;
    }

    public function setHour13(?int $hour13): void
    {
        $this->hour13 = $hour13;
    }

    public function getHour14(): ?int
    {
        return $this->hour14;
    }

    public function setHour14(?int $hour14): void
    {
        $this->hour14 = $hour14;
    }

    public function getHour15(): ?int
    {
        return $this->hour15;
    }

    public function setHour15(?int $hour15): void
    {
        $this->hour15 = $hour15;
    }

    public function getHour16(): ?int
    {
        return $this->hour16;
    }

    public function setHour16(?int $hour16): void
    {
        $this->hour16 = $hour16;
    }

    public function getHour17(): ?int
    {
        return $this->hour17;
    }

    public function setHour17(?int $hour17): void
    {
        $this->hour17 = $hour17;
    }

    public function getHour18(): ?int
    {
        return $this->hour18;
    }

    public function setHour18(?int $hour18): void
    {
        $this->hour18 = $hour18;
    }

    public function getHour19(): ?int
    {
        return $this->hour19;
    }

    public function setHour19(?int $hour19): void
    {
        $this->hour19 = $hour19;
    }

    public function getHour20(): ?int
    {
        return $this->hour20;
    }

    public function setHour20(?int $hour20): void
    {
        $this->hour20 = $hour20;
    }

    public function getHour21(): ?int
    {
        return $this->hour21;
    }

    public function setHour21(?int $hour21): void
    {
        $this->hour21 = $hour21;
    }

    public function getHour22(): ?int
    {
        return $this->hour22;
    }

    public function setHour22(?int $hour22): void
    {
        $this->hour22 = $hour22;
    }

    public function getHour23(): ?int
    {
        return $this->hour23;
    }

    public function setHour23(?int $hour23): void
    {
        $this->hour23 = $hour23;
    }
}
