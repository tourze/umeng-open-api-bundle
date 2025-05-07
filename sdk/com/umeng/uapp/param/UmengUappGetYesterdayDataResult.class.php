<?php

class UmengUappGetYesterdayDataResult
{
    private $yesterdayData;

    private $stdResult;

    private $arrayResult;

    public function getYesterdayData()
    {
        return $this->yesterdayData;
    }

    /**
     * 设置
     *
     * @param UmengUappDailyDataInfo $yesterdayData
     * 此参数必填     */
    public function setYesterdayData(UmengUappDailyDataInfo $yesterdayData)
    {
        $this->yesterdayData = $yesterdayData;
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('yesterdayData')) {
            $yesterdayDataResult = $arrayResult['yesterdayData'];
            $this->yesterdayData = new UmengUappDailyDataInfo();
            $this->yesterdayData->setStdResult($yesterdayDataResult);
        }
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'yesterdayData')) {
            $yesterdayDataResult = $this->stdResult->{'yesterdayData'};
            $this->yesterdayData = new UmengUappDailyDataInfo();
            $this->yesterdayData->setStdResult($yesterdayDataResult);
        }
    }
}
