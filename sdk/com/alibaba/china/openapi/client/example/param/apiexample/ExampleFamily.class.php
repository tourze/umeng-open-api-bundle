<?php

class ExampleFamily extends SDKDomain
{
    private $familyNumber;

    private $father;

    private $mother;

    private $children;

    private $ownedCars;

    private $myHouse;

    private $stdResult;

    private $arrayResult;

    /**
     * @return int|null 家庭编号
     */
    public function getFamilyNumber(): ?int
    {
        return $this->familyNumber;
    }

    /**
     * 设置家庭编号
     *
     * @param int $familyNumber
     *                          参数示例：<pre></pre>
     *                          此参数必填
     */
    public function setFamilyNumber(?int $familyNumber): void
    {
        $this->familyNumber = $familyNumber;
    }

    /**
     * @return ExamplePerson|null 父亲对象，可以为空
     */
    public function getFather(): ?ExamplePerson
    {
        return $this->father;
    }

    /**
     * 设置父亲对象，可以为空
     *
     * @param ExamplePerson $father
     *                              参数示例：<pre></pre>
     *                              此参数必填
     */
    public function setFather(?ExamplePerson $father): void
    {
        $this->father = $father;
    }

    /**
     * @return ExamplePerson|null 母亲对象，可以为空
     */
    public function getMother(): ?ExamplePerson
    {
        return $this->mother;
    }

    /**
     * 设置母亲对象，可以为空
     *
     * @param ExamplePerson $mother
     *                              参数示例：<pre></pre>
     *                              此参数必填
     */
    public function setMother(?ExamplePerson $mother): void
    {
        $this->mother = $mother;
    }

    /**
     * @return array|null 孩子列表
     */
    public function getChildren(): ?array
    {
        return $this->children;
    }

    /**
     * 设置孩子列表
     *
     * @param array|null $children ExamplePerson[] 参数示例：此参数必填
     */
    public function setChildren(?array $children): void
    {
        $this->children = $children;
    }

    /**
     * @return array|null 拥有的汽车信息
     */
    public function getOwnedCars(): ?array
    {
        return $this->ownedCars;
    }

    /**
     * 设置拥有的汽车信息
     *
     * @param array|null $ownedCars ExampleCar[] 参数示例：此参数必填
     */
    public function setOwnedCars(?array $ownedCars): void
    {
        $this->ownedCars = $ownedCars;
    }

    /**
     * @return mixed|null 所住的房屋信息
     */
    public function getMyHouse(): mixed
    {
        return $this->myHouse;
    }

    /**
     * 设置所住的房屋信息
     *
     * @param ExampleHouse $myHouse
     *                              参数示例：<pre></pre>
     *                              此参数必填
     */
    public function setMyHouse(mixed $myHouse): void
    {
        $this->myHouse = $myHouse;
    }

    public function setStdResult(mixed $stdResult): void
    {
        $this->stdResult = $stdResult;
        $object = json_encode($stdResult);
        if (property_exists($this->stdResult, 'familyNumber')) {
            $this->familyNumber = $this->stdResult->{'familyNumber'};
        }
        if (property_exists($this->stdResult, 'father')) {
            $fatherResult = $this->stdResult->{'father'};
            $this->father = new ExamplePerson();
            $this->father->setStdResult($fatherResult);
        }
        if (property_exists($this->stdResult, 'mother')) {
            $motherResult = $this->stdResult->{'mother'};
            $this->mother = new ExamplePerson();
            $this->mother->setStdResult($motherResult);
        }
        if (property_exists($this->stdResult, 'children')) {
            $childrenResult = $this->stdResult->{'children'};
            $object = json_decode(json_encode($childrenResult), true);
            $this->children = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $ExamplePersonResult = new ExamplePerson();
                $ExamplePersonResult->setArrayResult($arrayobject);
                $this->children[$i] = $ExamplePersonResult;
            }
        }
        if (property_exists($this->stdResult, 'ownedCars')) {
            $ownedCarsResult = $this->stdResult->{'ownedCars'};
            $object = json_decode(json_encode($ownedCarsResult), true);
            $this->ownedCars = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $ExampleCarResult = new ExampleCar();
                $ExampleCarResult->setArrayResult($arrayobject);
                $this->ownedCars[$i] = $ExampleCarResult;
            }
        }
        if (property_exists($this->stdResult, 'myHouse')) {
            $myHouseResult = $this->stdResult->{'myHouse'};
            $this->myHouse = new ExampleHouse();
            $this->myHouse->setStdResult($myHouseResult);
        }
    }

    public function setArrayResult(ArrayObject $arrayResult): void
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('familyNumber')) {
            $this->familyNumber = $arrayResult['familyNumber'];
        }
        if ($arrayResult->offsetExists('father')) {
            $fatherResult = $arrayResult['father'];
            $this->father = new ExamplePerson();
            $this->father->setStdResult($fatherResult);
        }
        if ($arrayResult->offsetExists('mother')) {
            $motherResult = $arrayResult['mother'];
            $this->mother = new ExamplePerson();
            $this->mother->setStdResult($motherResult);
        }
        if ($arrayResult->offsetExists('children')) {
            $childrenResult = $arrayResult['children'];
            $this->children = new ExamplePerson();
            $this->children->setStdResult($childrenResult);
        }
        if ($arrayResult->offsetExists('ownedCars')) {
            $ownedCarsResult = $arrayResult['ownedCars'];
            $this->ownedCars = new ExampleCar();
            $this->ownedCars->setStdResult($ownedCarsResult);
        }
        if ($arrayResult->offsetExists('myHouse')) {
            $myHouseResult = $arrayResult['myHouse'];
            $this->myHouse = new ExampleHouse();
            $this->myHouse->setStdResult($myHouseResult);
        }
    }
}
