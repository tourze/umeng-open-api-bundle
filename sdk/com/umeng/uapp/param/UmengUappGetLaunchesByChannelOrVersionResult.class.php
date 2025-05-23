<?php

class UmengUappGetLaunchesByChannelOrVersionResult
{
    private $launchInfo;

    private $stdResult;

    private $arrayResult;

    public function getLaunchInfo()
    {
        return $this->launchInfo;
    }

    /**
     * 设置
     *
     * @param array include @see UmengUappCountData[] $launchInfo
     * 此参数必填     */
    public function setLaunchInfo(UmengUappCountData $launchInfo)
    {
        $this->launchInfo = $launchInfo;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'launchInfo')) {
            $launchInfoResult = $this->stdResult->{'launchInfo'};
            $object = json_decode(json_encode($launchInfoResult), true);
            $this->launchInfo = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappCountDataResult = new UmengUappCountData();
                $UmengUappCountDataResult->setArrayResult($arrayobject);
                $this->launchInfo[$i] = $UmengUappCountDataResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('launchInfo')) {
            $launchInfoResult = $arrayResult['launchInfo'];
            $this->launchInfo = new UmengUappCountData();
            $this->launchInfo->setStdResult($launchInfoResult);
        }
    }
}
