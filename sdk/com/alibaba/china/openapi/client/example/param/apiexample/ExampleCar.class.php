<?php

class ExampleCar extends SDKDomain
{
    private $builtDate;

    private $boughtDate;

    private $name;

    private $builtArea;

    private $carNumber;

    private $price;

    private $seats;

    private $stdResult;

    private $arrayResult;

    public function getBuiltDate()
    {
        return $this->builtDate;
    }

    /**
     * 设置
     *
     * @param Date $builtDate
     *                        参数示例：<pre></pre>
     *                        此参数必填
     */
    public function setBuiltDate($builtDate)
    {
        $this->builtDate = $builtDate;
    }

    public function getBoughtDate()
    {
        return $this->boughtDate;
    }

    /**
     * 设置
     *
     * @param Date $boughtDate
     *                         参数示例：<pre></pre>
     *                         此参数必填
     */
    public function setBoughtDate($boughtDate)
    {
        $this->boughtDate = $boughtDate;
    }

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

    public function getBuiltArea()
    {
        return $this->builtArea;
    }

    /**
     * 设置
     *
     * @param string $builtArea
     *                          参数示例：<pre></pre>
     *                          此参数必填
     */
    public function setBuiltArea($builtArea)
    {
        $this->builtArea = $builtArea;
    }

    public function getCarNumber()
    {
        return $this->carNumber;
    }

    /**
     * 设置
     *
     * @param string $carNumber
     *                          参数示例：<pre></pre>
     *                          此参数必填
     */
    public function setCarNumber($carNumber)
    {
        $this->carNumber = $carNumber;
    }

    public function getPrice()
    {
        return $this->price;
    }

    /**
     * 设置
     *
     * @param float $price
     *                     参数示例：<pre></pre>
     *                     此参数必填
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getSeats()
    {
        return $this->seats;
    }

    /**
     * 设置
     *
     * @param int $seats
     *                   参数示例：<pre></pre>
     *                   此参数必填
     */
    public function setSeats($seats)
    {
        $this->seats = $seats;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'builtDate')) {
            $this->builtDate = $this->stdResult->{'builtDate'};
        }
        if (property_exists($this->stdResult, 'boughtDate')) {
            $this->boughtDate = $this->stdResult->{'boughtDate'};
        }
        if (property_exists($this->stdResult, 'name')) {
            $this->name = $this->stdResult->{'name'};
        }
        if (property_exists($this->stdResult, 'builtArea')) {
            $this->builtArea = $this->stdResult->{'builtArea'};
        }
        if (property_exists($this->stdResult, 'carNumber')) {
            $this->carNumber = $this->stdResult->{'carNumber'};
        }
        if (property_exists($this->stdResult, 'price')) {
            $this->price = $this->stdResult->{'price'};
        }
        if (property_exists($this->stdResult, 'seats')) {
            $this->seats = $this->stdResult->{'seats'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('builtDate')) {
            $this->builtDate = $arrayResult['builtDate'];
        }
        if ($arrayResult->offsetExists('boughtDate')) {
            $this->boughtDate = $arrayResult['boughtDate'];
        }
        if ($arrayResult->offsetExists('name')) {
            $this->name = $arrayResult['name'];
        }
        if ($arrayResult->offsetExists('builtArea')) {
            $this->builtArea = $arrayResult['builtArea'];
        }
        if ($arrayResult->offsetExists('carNumber')) {
            $this->carNumber = $arrayResult['carNumber'];
        }
        if ($arrayResult->offsetExists('price')) {
            $this->price = $arrayResult['price'];
        }
        if ($arrayResult->offsetExists('seats')) {
            $this->seats = $arrayResult['seats'];
        }
    }
}
