<?php

class UmengApptrackGetStayTrendDataResult
{
    private $stay1;

    private $stay2;

    private $stay3;

    private $stay4;

    private $stay5;

    private $stay6;

    private $stay7;

    private $stay8;

    private $stay9;

    private $stay10;

    private $stay11;

    private $stay12;

    private $stay13;

    private $stay14;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 次日留存数据
     */
    public function getStay1()
    {
        return $this->stay1;
    }

    /**
     * 设置次日留存数据
     *
     * @param Long $stay1
     * 此参数必填     */
    public function setStay1($stay1)
    {
        $this->stay1 = $stay1;
    }

    /**
     * @return 第3日留存数据
     */
    public function getStay2()
    {
        return $this->stay2;
    }

    /**
     * 设置第3日留存数据
     *
     * @param Long $stay2
     * 此参数必填     */
    public function setStay2($stay2)
    {
        $this->stay2 = $stay2;
    }

    /**
     * @return 第4日留存数据
     */
    public function getStay3()
    {
        return $this->stay3;
    }

    /**
     * 设置第4日留存数据
     *
     * @param Long $stay3
     * 此参数必填     */
    public function setStay3($stay3)
    {
        $this->stay3 = $stay3;
    }

    /**
     * @return 第5日留存数据
     */
    public function getStay4()
    {
        return $this->stay4;
    }

    /**
     * 设置第5日留存数据
     *
     * @param Long $stay4
     * 此参数必填     */
    public function setStay4($stay4)
    {
        $this->stay4 = $stay4;
    }

    /**
     * @return 第6日留存数据
     */
    public function getStay5()
    {
        return $this->stay5;
    }

    /**
     * 设置第6日留存数据
     *
     * @param Long $stay5
     * 此参数必填     */
    public function setStay5($stay5)
    {
        $this->stay5 = $stay5;
    }

    /**
     * @return 第7日留存数据
     */
    public function getStay6()
    {
        return $this->stay6;
    }

    /**
     * 设置第7日留存数据
     *
     * @param Long $stay6
     * 此参数必填     */
    public function setStay6($stay6)
    {
        $this->stay6 = $stay6;
    }

    /**
     * @return 第8日留存数据
     */
    public function getStay7()
    {
        return $this->stay7;
    }

    /**
     * 设置第8日留存数据
     *
     * @param Long $stay7
     * 此参数必填     */
    public function setStay7($stay7)
    {
        $this->stay7 = $stay7;
    }

    /**
     * @return 第9日留存数据
     */
    public function getStay8()
    {
        return $this->stay8;
    }

    /**
     * 设置第9日留存数据
     *
     * @param Long $stay8
     * 此参数必填     */
    public function setStay8($stay8)
    {
        $this->stay8 = $stay8;
    }

    /**
     * @return 第10日留存数据
     */
    public function getStay9()
    {
        return $this->stay9;
    }

    /**
     * 设置第10日留存数据
     *
     * @param Long $stay9
     * 此参数必填     */
    public function setStay9($stay9)
    {
        $this->stay9 = $stay9;
    }

    /**
     * @return 第11日留存数据
     */
    public function getStay10()
    {
        return $this->stay10;
    }

    /**
     * 设置第11日留存数据
     *
     * @param Long $stay10
     * 此参数必填     */
    public function setStay10($stay10)
    {
        $this->stay10 = $stay10;
    }

    /**
     * @return 第12日留存数据
     */
    public function getStay11()
    {
        return $this->stay11;
    }

    /**
     * 设置第12日留存数据
     *
     * @param Long $stay11
     * 此参数必填     */
    public function setStay11($stay11)
    {
        $this->stay11 = $stay11;
    }

    /**
     * @return 第13日留存数据
     */
    public function getStay12()
    {
        return $this->stay12;
    }

    /**
     * 设置第13日留存数据
     *
     * @param Long $stay12
     * 此参数必填     */
    public function setStay12($stay12)
    {
        $this->stay12 = $stay12;
    }

    /**
     * @return 第14日留存数据
     */
    public function getStay13()
    {
        return $this->stay13;
    }

    /**
     * 设置第14日留存数据
     *
     * @param Long $stay13
     * 此参数必填     */
    public function setStay13($stay13)
    {
        $this->stay13 = $stay13;
    }

    /**
     * @return 第15日留存数据
     */
    public function getStay14()
    {
        return $this->stay14;
    }

    /**
     * 设置第15日留存数据
     *
     * @param Long $stay14
     * 此参数必填     */
    public function setStay14($stay14)
    {
        $this->stay14 = $stay14;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'stay1')) {
            $this->stay1 = $this->stdResult->{'stay1'};
        }
        if (property_exists($this->stdResult, 'stay2')) {
            $this->stay2 = $this->stdResult->{'stay2'};
        }
        if (property_exists($this->stdResult, 'stay3')) {
            $this->stay3 = $this->stdResult->{'stay3'};
        }
        if (property_exists($this->stdResult, 'stay4')) {
            $this->stay4 = $this->stdResult->{'stay4'};
        }
        if (property_exists($this->stdResult, 'stay5')) {
            $this->stay5 = $this->stdResult->{'stay5'};
        }
        if (property_exists($this->stdResult, 'stay6')) {
            $this->stay6 = $this->stdResult->{'stay6'};
        }
        if (property_exists($this->stdResult, 'stay7')) {
            $this->stay7 = $this->stdResult->{'stay7'};
        }
        if (property_exists($this->stdResult, 'stay8')) {
            $this->stay8 = $this->stdResult->{'stay8'};
        }
        if (property_exists($this->stdResult, 'stay9')) {
            $this->stay9 = $this->stdResult->{'stay9'};
        }
        if (property_exists($this->stdResult, 'stay10')) {
            $this->stay10 = $this->stdResult->{'stay10'};
        }
        if (property_exists($this->stdResult, 'stay11')) {
            $this->stay11 = $this->stdResult->{'stay11'};
        }
        if (property_exists($this->stdResult, 'stay12')) {
            $this->stay12 = $this->stdResult->{'stay12'};
        }
        if (property_exists($this->stdResult, 'stay13')) {
            $this->stay13 = $this->stdResult->{'stay13'};
        }
        if (property_exists($this->stdResult, 'stay14')) {
            $this->stay14 = $this->stdResult->{'stay14'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('stay1')) {
            $this->stay1 = $arrayResult['stay1'];
        }
        if ($arrayResult->offsetExists('stay2')) {
            $this->stay2 = $arrayResult['stay2'];
        }
        if ($arrayResult->offsetExists('stay3')) {
            $this->stay3 = $arrayResult['stay3'];
        }
        if ($arrayResult->offsetExists('stay4')) {
            $this->stay4 = $arrayResult['stay4'];
        }
        if ($arrayResult->offsetExists('stay5')) {
            $this->stay5 = $arrayResult['stay5'];
        }
        if ($arrayResult->offsetExists('stay6')) {
            $this->stay6 = $arrayResult['stay6'];
        }
        if ($arrayResult->offsetExists('stay7')) {
            $this->stay7 = $arrayResult['stay7'];
        }
        if ($arrayResult->offsetExists('stay8')) {
            $this->stay8 = $arrayResult['stay8'];
        }
        if ($arrayResult->offsetExists('stay9')) {
            $this->stay9 = $arrayResult['stay9'];
        }
        if ($arrayResult->offsetExists('stay10')) {
            $this->stay10 = $arrayResult['stay10'];
        }
        if ($arrayResult->offsetExists('stay11')) {
            $this->stay11 = $arrayResult['stay11'];
        }
        if ($arrayResult->offsetExists('stay12')) {
            $this->stay12 = $arrayResult['stay12'];
        }
        if ($arrayResult->offsetExists('stay13')) {
            $this->stay13 = $arrayResult['stay13'];
        }
        if ($arrayResult->offsetExists('stay14')) {
            $this->stay14 = $arrayResult['stay14'];
        }
    }
}
