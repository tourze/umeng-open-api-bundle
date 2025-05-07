<?php

class UmengUappEventParamListResult
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
     * @param array include @see UmengUappParamInfo[] $paramInfos
     * 此参数必填     */
    public function setParamInfos(UmengUappParamInfo $paramInfos)
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
                $UmengUappParamInfoResult = new UmengUappParamInfo();
                $UmengUappParamInfoResult->setArrayResult($arrayobject);
                $this->paramInfos[$i] = $UmengUappParamInfoResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('paramInfos')) {
            $paramInfosResult = $arrayResult['paramInfos'];
            $this->paramInfos = new UmengUappParamInfo();
            $this->paramInfos->setStdResult($paramInfosResult);
        }
    }
}
