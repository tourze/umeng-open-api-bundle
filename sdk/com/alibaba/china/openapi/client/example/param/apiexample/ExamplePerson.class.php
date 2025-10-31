<?php

class ExamplePerson extends SDKDomain
{
    private $name;

    private $age;

    private $birthday;

    private $mobileNumber;

    private $stdResult;

    public function getName(): ?string
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
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getAge(): ?int
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
    public function setAge(?int $age): void
    {
        $this->age = $age;
    }

    public function getBirthday(): mixed
    {
        return $this->birthday;
    }

    /**
     * 设置
     *
     * @param string|DateTime $birthday
     *                                  参数示例：<pre></pre>
     *                                  此参数必填
     */
    public function setBirthday(mixed $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function getMobileNumber(): ?string
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
    public function setMobileNumber(?string $mobileNumber): void
    {
        $this->mobileNumber = $mobileNumber;
    }

    public function setStdResult(mixed $stdResult): void
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'name')) {
            $this->name = $this->stdResult->name;
        }
        if (property_exists($this->stdResult, 'age')) {
            $this->age = $this->stdResult->age;
        }
        if (property_exists($this->stdResult, 'birthday')) {
            $this->birthday = $this->stdResult->birthday;
        }
        if (property_exists($this->stdResult, 'mobileNumber')) {
            $this->mobileNumber = $this->stdResult->mobileNumber;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult): void
    {
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
