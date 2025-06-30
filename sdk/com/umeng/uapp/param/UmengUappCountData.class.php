<?php

class UmengUappCountData extends SDKDomain
{
    private $date;

    private $dailyValue;

    private $hourValue;

    private $value;

    private $stdResult;

    private $arrayResult;

    /**
     * @return string 统计日期
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * 设置统计日期
     *
     * @param string $date
     *                     参数示例：<pre>2018-01-01</pre>
     * 此参数必填     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string 按版本或渠道的统计信息
     */
    public function getDailyValue()
    {
        return $this->dailyValue;
    }

    /**
     * 设置按版本或渠道的统计信息
     *
     * @param array include @see UmengUappCountDataNameValue[] $dailyValue
     * 参数示例：<pre></pre>
     * 此参数必填     */
    public function setDailyValue(UmengUappCountDataNameValue $dailyValue)
    {
        $this->dailyValue = $dailyValue;
    }

    /**
     * @return array 按小时查询返回数组
     */
    public function getHourValue()
    {
        return $this->hourValue;
    }

    /**
     * 设置按小时查询返回数组
     *
     * @param array include @see Integer[] $hourValue
     * 参数示例：<pre></pre>
     * 此参数必填     */
    public function setHourValue($hourValue)
    {
        $this->hourValue = $hourValue;
    }

    /**
     * @return string 其它情况返回整型，按天无版本无渠道，按周，按月查询
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * 设置其它情况返回整型，按天无版本无渠道，按周，按月查询。
     *
     * @param int $value
     *                   参数示例：<pre></pre>
     * 此参数必填     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'date')) {
            $this->date = $this->stdResult->{'date'};
        }
        if (property_exists($this->stdResult, 'dailyValue')) {
            $dailyValueResult = $this->stdResult->{'dailyValue'};
            $object = json_decode(json_encode($dailyValueResult), true);
            $this->dailyValue = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappCountDataNameValueResult = new UmengUappCountDataNameValue();
                $UmengUappCountDataNameValueResult->setArrayResult($arrayobject);
                $this->dailyValue[$i] = $UmengUappCountDataNameValueResult;
            }
        }
        if (property_exists($this->stdResult, 'hourValue')) {
            $this->hourValue = $this->stdResult->{'hourValue'};
        }
        if (property_exists($this->stdResult, 'value')) {
            $this->value = $this->stdResult->{'value'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('date')) {
            $this->date = $arrayResult['date'];
        }
        if ($arrayResult->offsetExists('dailyValue')) {
            $dailyValueResult = $arrayResult['dailyValue'];
            $this->dailyValue = new UmengUappCountDataNameValue();
            $this->dailyValue->setStdResult($dailyValueResult);
        }
        if ($arrayResult->offsetExists('hourValue')) {
            $this->hourValue = $arrayResult['hourValue'];
        }
        if ($arrayResult->offsetExists('value')) {
            $this->value = $arrayResult['value'];
        }
    }
}
