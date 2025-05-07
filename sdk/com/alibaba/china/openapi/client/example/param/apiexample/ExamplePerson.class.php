<?php

class ExamplePerson extends SDKDomain
{
    private $name;

    private $age;

    private $birthday;

    private $mobileNumber;

    private $stdResult;

    private $arrayResult;

    public function getName()
    {
        return $this->name;
    }

    /**
     * 设置
     *
     * @param string $name
     *                     参数示例：<pre></pre>
     *                     此参数必填
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getAge()
    {
        return $this->age;
    }

    /**
     * 设置
     *
     * @param int $age
     *                 参数示例：<pre></pre>
     *                 此参数必填
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * 设置
     *
     * @param Date $birthday
     *                       参数示例：<pre></pre>
     *                       此参数必填
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    /**
     * 设置
     *
     * @param string $mobileNumber
     *                             参数示例：<pre></pre>
     *                             此参数必填
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'name')) {
            $this->name = $this->stdResult->{'name'};
        }
        if (property_exists($this->stdResult, 'age')) {
            $this->age = $this->stdResult->{'age'};
        }
        if (property_exists($this->stdResult, 'birthday')) {
            $this->birthday = $this->stdResult->{'birthday'};
        }
        if (property_exists($this->stdResult, 'mobileNumber')) {
            $this->mobileNumber = $this->stdResult->{'mobileNumber'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('name')) {
            $this->name = $arrayResult['name'];
        }
        if ($arrayResult->offsetExists('age')) {
            $this->age = $arrayResult['age'];
        }
        if ($arrayResult->offsetExists('birthday')) {
            $this->birthday = $arrayResult['birthday'];
        }
        if ($arrayResult->offsetExists('mobileNumber')) {
            $this->mobileNumber = $arrayResult['mobileNumber'];
        }
    }
}
