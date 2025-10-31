<?php

class UmengUappDateCountInfo extends SDKDomain
{
    private $dates;

    private $data;

    private $stdResult;

    /**
     * @return array 统计日期数组
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * 设置统计日期数组
     *
     * @param string[] $dates
     *                        参数示例：<pre>"2018-01-01","2018-01-02"</pre>
     * 此参数必填     */
    public function setDates($dates)
    {
        $this->dates = $dates;
    }

    /**
     * @return array 统计数据数组
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置统计数据数组
     *
     * @param int[] $data
     *                    参数示例：<pre>1234,5678</pre>
     * 此参数必填     */
    public function setData($data)
    {
        $this->data = $data;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'dates')) {
            $this->dates = $this->stdResult->dates;
        }
        if (property_exists($this->stdResult, 'data')) {
            $this->data = $this->stdResult->data;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('dates')) {
            $this->dates = $arrayResult['dates'];
        }
        if ($arrayResult->offsetExists('data')) {
            $this->data = $arrayResult['data'];
        }
    }
}
