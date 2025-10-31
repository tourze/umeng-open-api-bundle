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

        $this->setFamilyNumberFromStdResult();
        $this->setParentsFromStdResult();
        $this->setChildrenFromStdResult();
        $this->setOwnedCarsFromStdResult();
        $this->setMyHouseFromStdResult();
    }

    private function setFamilyNumberFromStdResult(): void
    {
        if (property_exists($this->stdResult, 'familyNumber')) {
            $this->familyNumber = $this->stdResult->familyNumber;
        }
    }

    private function setParentsFromStdResult(): void
    {
        if (property_exists($this->stdResult, 'father')) {
            $this->father = new ExamplePerson();
            $this->father->setStdResult($this->stdResult->father);
        }

        if (property_exists($this->stdResult, 'mother')) {
            $this->mother = new ExamplePerson();
            $this->mother->setStdResult($this->stdResult->mother);
        }
    }

    private function setChildrenFromStdResult(): void
    {
        if (!property_exists($this->stdResult, 'children')) {
            return;
        }

        $childrenData = json_decode(json_encode($this->stdResult->children), true);
        $this->children = [];

        foreach ($childrenData as $i => $childData) {
            $arrayObject = new ArrayObject($childData);
            $child = new ExamplePerson();
            $child->setArrayResult($arrayObject);
            $this->children[$i] = $child;
        }
    }

    private function setOwnedCarsFromStdResult(): void
    {
        if (!property_exists($this->stdResult, 'ownedCars')) {
            return;
        }

        $carsData = json_decode(json_encode($this->stdResult->ownedCars), true);
        $this->ownedCars = [];

        foreach ($carsData as $i => $carData) {
            $arrayObject = new ArrayObject($carData);
            $car = new ExampleCar();
            $car->setArrayResult($arrayObject);
            $this->ownedCars[$i] = $car;
        }
    }

    private function setMyHouseFromStdResult(): void
    {
        if (property_exists($this->stdResult, 'myHouse')) {
            $this->myHouse = new ExampleHouse();
            $this->myHouse->setStdResult($this->stdResult->myHouse);
        }
    }

    public function setArrayResult(ArrayObject $arrayResult): void
    {
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
