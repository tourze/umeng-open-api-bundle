<?php

class UmengUappGetRetentionsResult
{
    private $retentionInfo;

    private $stdResult;

    private $arrayResult;

    public function getRetentionInfo()
    {
        return $this->retentionInfo;
    }

    /**
     * 设置
     *
     * @param array include @see UmengUappRetentionInfo[] $retentionInfo
     * 此参数必填     */
    public function setRetentionInfo(UmengUappRetentionInfo $retentionInfo)
    {
        $this->retentionInfo = $retentionInfo;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'retentionInfo')) {
            $retentionInfoResult = $this->stdResult->{'retentionInfo'};
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
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('retentionInfo')) {
            $retentionInfoResult = $arrayResult['retentionInfo'];
            $this->retentionInfo = new UmengUappRetentionInfo();
            $this->retentionInfo->setStdResult($retentionInfoResult);
        }
    }
}
