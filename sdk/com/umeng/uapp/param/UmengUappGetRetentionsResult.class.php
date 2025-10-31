<?php

class UmengUappGetRetentionsResult
{
    private $retentionInfo;

    private $stdResult;

    public function getRetentionInfo()
    {
        return $this->retentionInfo;
    }

    /**
     * 设置
     *
     * @param UmengUappRetentionInfo[] $retentionInfo
     * 此参数必填     */
    public function setRetentionInfo(array $retentionInfo)
    {
        $this->retentionInfo = $retentionInfo;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'retentionInfo')) {
            $retentionInfoResult = $this->stdResult->retentionInfo;
            $object = json_decode(json_encode($retentionInfoResult), true);
            $this->retentionInfo = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappRetentionInfoResult = new UmengUappRetentionInfo();
                $UmengUappRetentionInfoResult->setArrayResult($arrayobject);
                $this->retentionInfo[$i] = $UmengUappRetentionInfoResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('retentionInfo')) {
            $retentionInfoResult = $arrayResult['retentionInfo'];
            $this->retentionInfo = new UmengUappRetentionInfo();
            $this->retentionInfo->setStdResult($retentionInfoResult);
        }
    }
}
