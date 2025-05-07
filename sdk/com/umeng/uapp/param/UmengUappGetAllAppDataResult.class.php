<?php

class UmengUappGetAllAppDataResult
{
    private $allAppData;

    private $stdResult;

    private $arrayResult;

    public function getAllAppData()
    {
        return $this->allAppData;
    }

    /**
     * 设置
     *
     * @param array include @see UmengUappAllAppData[] $allAppData
     * 此参数必填     */
    public function setAllAppData(UmengUappAllAppData $allAppData)
    {
        $this->allAppData = $allAppData;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'allAppData')) {
            $allAppDataResult = $this->stdResult->{'allAppData'};
            $object = json_decode(json_encode($allAppDataResult), true);
            $this->allAppData = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappAllAppDataResult = new UmengUappAllAppData();
                $UmengUappAllAppDataResult->setArrayResult($arrayobject);
                $this->allAppData[$i] = $UmengUappAllAppDataResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('allAppData')) {
            $allAppDataResult = $arrayResult['allAppData'];
            $this->allAppData = new UmengUappAllAppData();
            $this->allAppData->setStdResult($allAppDataResult);
        }
    }
}
