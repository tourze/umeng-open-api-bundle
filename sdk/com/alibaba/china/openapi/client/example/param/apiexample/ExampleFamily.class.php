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
     * @return 家庭编号
     */
    public function getFamilyNumber()
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
    public function setFamilyNumber($familyNumber)
    {
        $this->familyNumber = $familyNumber;
    }

    /**
     * @return 父亲对象，可以为空
     */
    public function getFather()
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
    public function setFather(ExamplePerson $father)
    {
        $this->father = $father;
    }

    /**
     * @return 母亲对象，可以为空
     */
    public function getMother()
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
    public function setMother(ExamplePerson $mother)
    {
        $this->mother = $mother;
    }

    /**
     * @return 孩子列表
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * 设置孩子列表
     *
     * @param
     *            array include @see ExamplePerson[] $children
     *            参数示例：<pre></pre>
     *            此参数必填
     */
    public function setChildren(ExamplePerson $children)
    {
        $this->children = $children;
    }

    /**
     * @return 拥有的汽车信息
     */
    public function getOwnedCars()
    {
        return $this->ownedCars;
    }

    /**
     * 设置拥有的汽车信息
     *
     * @param
     *            array include @see ExampleCar[] $ownedCars
     *            参数示例：<pre></pre>
     *            此参数必填
     */
    public function setOwnedCars(ExampleCar $ownedCars)
    {
        $this->ownedCars = $ownedCars;
    }

    /**
     * @return 所住的房屋信息
     */
    public function getMyHouse()
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
    public function setMyHouse(ExampleHouse $myHouse)
    {
        $this->myHouse = $myHouse;
    }

    public function setStdResult($stdResult)
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

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('familyNumber')) {
            $this->familyNumber = $arrayResult['familyNumber'];
        }
        if ($arrayResult->offsetExists('father')) {
            $fatherResult = $arrayResult['father'];
            $this->father = new ExamplePerson();
            $this->father->$this->setStdResult($fatherResult);
        }
        if ($arrayResult->offsetExists('mother')) {
            $motherResult = $arrayResult['mother'];
            $this->mother = new ExamplePerson();
            $this->mother->$this->setStdResult($motherResult);
        }
        if ($arrayResult->offsetExists('children')) {
            $childrenResult = $arrayResult['children'];
            $this->children = ExamplePerson();
            $this->children->$this->setStdResult($childrenResult);
        }
        if ($arrayResult->offsetExists('ownedCars')) {
            $ownedCarsResult = $arrayResult['ownedCars'];
            $this->ownedCars = ExampleCar();
            $this->ownedCars->$this->setStdResult($ownedCarsResult);
        }
        if ($arrayResult->offsetExists('myHouse')) {
            $myHouseResult = $arrayResult['myHouse'];
            $this->myHouse = new ExampleHouse();
            $this->myHouse->$this->setStdResult($myHouseResult);
        }
    }
}
