<?php

class UmengUappGetTodayYesterdayDataResult
{
    private $todayData;

    private $yesterdayData;

    private $stdResult;

    public function getTodayData()
    {
        return $this->todayData;
    }

    /**
     * 设置
     *
     * @param UmengUappDailyDataInfo $todayData
     * 此参数必填     */
    public function setTodayData(UmengUappDailyDataInfo $todayData)
    {
        $this->todayData = $todayData;
    }

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
        if ($arrayResult->offsetExists('todayData')) {
            $todayDataResult = $arrayResult['todayData'];
            $this->todayData = new UmengUappDailyDataInfo();
            $this->todayData->setStdResult($todayDataResult);
        }
        if ($arrayResult->offsetExists('yesterdayData')) {
            $yesterdayDataResult = $arrayResult['yesterdayData'];
            $this->yesterdayData = new UmengUappDailyDataInfo();
            $this->yesterdayData->setStdResult($yesterdayDataResult);
        }
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'todayData')) {
            $todayDataResult = $this->stdResult->todayData;
            $this->todayData = new UmengUappDailyDataInfo();
            $this->todayData->setStdResult($todayDataResult);
        }
        if (property_exists($this->stdResult, 'yesterdayData')) {
            $yesterdayDataResult = $this->stdResult->yesterdayData;
            $this->yesterdayData = new UmengUappDailyDataInfo();
            $this->yesterdayData->setStdResult($yesterdayDataResult);
        }
    }
}
