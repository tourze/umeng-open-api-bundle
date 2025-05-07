<?php

class UmengUappGetDurationsResult
{
    private $durationInfos;

    private $average;

    private $stdResult;

    private $arrayResult;

    /**
     * @return UmengUappDurationInfo[]
     */
    public function getDurationInfos()
    {
        return $this->durationInfos;
    }

    /**
     * 设置
     *
     * @param array include @see UmengUappDurationInfo[] $durationInfos
     * 此参数必填     */
    public function setDurationInfos(UmengUappDurationInfo $durationInfos)
    {
        $this->durationInfos = $durationInfos;
    }

    /**
     * @return 每次启动的平均使用时长
     */
    public function getAverage()
    {
        return $this->average;
    }

    /**
     * 设置每次启动的平均使用时长
     *
     * @param float $average
     * 此参数必填     */
    public function setAverage($average)
    {
        $this->average = $average;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'durationInfos')) {
            $durationInfosResult = $this->stdResult->{'durationInfos'};
            $object = json_decode(json_encode($durationInfosResult), true);
            $this->durationInfos = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappDurationInfoResult = new UmengUappDurationInfo();
                $UmengUappDurationInfoResult->setArrayResult($arrayobject);
                $this->durationInfos[$i] = $UmengUappDurationInfoResult;
            }
        }
        if (property_exists($this->stdResult, 'average')) {
            $this->average = $this->stdResult->{'average'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('durationInfos')) {
            $durationInfosResult = $arrayResult['durationInfos'];
            $this->durationInfos = new UmengUappDurationInfo();
            $this->durationInfos->setStdResult($durationInfosResult);
        }
        if ($arrayResult->offsetExists('average')) {
            $this->average = $arrayResult['average'];
        }
    }
}
