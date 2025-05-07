<?php

class UmengUappEventParamGetValueDurationListResult
{
    private $paramInfos;

    private $stdResult;

    private $arrayResult;

    public function getParamInfos()
    {
        return $this->paramInfos;
    }

    /**
     * 设置
     *
     * @param array include @see UmengUappParamValueInfo[] $paramInfos
     * 此参数必填     */
    public function setParamInfos(UmengUappParamValueInfo $paramInfos)
    {
        $this->paramInfos = $paramInfos;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'paramInfos')) {
            $paramInfosResult = $this->stdResult->{'paramInfos'};
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
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('paramInfos')) {
            $paramInfosResult = $arrayResult['paramInfos'];
            $this->paramInfos = new UmengUappParamValueInfo();
            $this->paramInfos->setStdResult($paramInfosResult);
        }
    }
}
