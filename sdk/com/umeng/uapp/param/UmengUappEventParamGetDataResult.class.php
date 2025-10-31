<?php

class UmengUappEventParamGetDataResult
{
    private $paramValueData;

    private $stdResult;

    public function getParamValueData()
    {
        return $this->paramValueData;
    }

    /**
     * 设置
     *
     * @param UmengUappDateCountInfo[] $paramValueData
     * 此参数必填     */
    public function setParamValueData(array $paramValueData)
    {
        $this->paramValueData = $paramValueData;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'paramValueData')) {
            $paramValueDataResult = $this->stdResult->paramValueData;
            $object = json_decode(json_encode($paramValueDataResult), true);
            $this->paramValueData = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappDateCountInfoResult = new UmengUappDateCountInfo();
                $UmengUappDateCountInfoResult->setArrayResult($arrayobject);
                $this->paramValueData[$i] = $UmengUappDateCountInfoResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('paramValueData')) {
            $paramValueDataResult = $arrayResult['paramValueData'];
            $this->paramValueData = new UmengUappDateCountInfo();
            $this->paramValueData->setStdResult($paramValueDataResult);
        }
    }
}
