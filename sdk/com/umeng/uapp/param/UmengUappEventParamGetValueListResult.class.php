<?php

class UmengUappEventParamGetValueListResult
{
    private $paramInfos;

    private $stdResult;

    public function getParamInfos()
    {
        return $this->paramInfos;
    }

    /**
     * 设置
     *
     * @param UmengUappParamValueInfo[] $paramInfos
     * 此参数必填     */
    public function setParamInfos(array $paramInfos)
    {
        $this->paramInfos = $paramInfos;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'paramInfos')) {
            $paramInfosResult = $this->stdResult->paramInfos;
            $object = json_decode(json_encode($paramInfosResult), true);
            $this->paramInfos = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappParamValueInfoResult = new UmengUappParamValueInfo();
                $UmengUappParamValueInfoResult->setArrayResult($arrayobject);
                $this->paramInfos[$i] = $UmengUappParamValueInfoResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('paramInfos')) {
            $paramInfosResult = $arrayResult['paramInfos'];
            $this->paramInfos = new UmengUappParamValueInfo();
            $this->paramInfos->setStdResult($paramInfosResult);
        }
    }
}
