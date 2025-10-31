<?php

class UmengUappGetDailyDataResult
{
    private $dailyData;

    private $stdResult;

    /**
     * @return UmengUappDailyDataInfo
     */
    public function getDailyData()
    {
        return $this->dailyData;
    }

    /**
     * 设置UmengUappDailyDataInfo
     *
     * @param UmengUappDailyDataInfo $dailyData
     * 此参数必填     */
    public function setDailyData(UmengUappDailyDataInfo $dailyData)
    {
        $this->dailyData = $dailyData;
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('dailyData')) {
            $dailyDataResult = $arrayResult['dailyData'];
            $this->dailyData = new UmengUappDailyDataInfo();
            $this->dailyData->setStdResult($dailyDataResult);
        }
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'dailyData')) {
            $dailyDataResult = $this->stdResult->dailyData;
            $this->dailyData = new UmengUappDailyDataInfo();
            $this->dailyData->setStdResult($dailyDataResult);
        }
    }
}
