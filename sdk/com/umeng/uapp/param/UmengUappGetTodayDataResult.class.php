<?php

class UmengUappGetTodayDataResult
{
    private $todayData;

    private $stdResult;

    private $arrayResult;

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

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('todayData')) {
            $todayDataResult = $arrayResult['todayData'];
            $this->todayData = new UmengUappDailyDataInfo();
            $this->todayData->setStdResult($todayDataResult);
        }
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'todayData')) {
            $todayDataResult = $this->stdResult->{'todayData'};
            $this->todayData = new UmengUappDailyDataInfo();
            $this->todayData->setStdResult($todayDataResult);
        }
    }
}
