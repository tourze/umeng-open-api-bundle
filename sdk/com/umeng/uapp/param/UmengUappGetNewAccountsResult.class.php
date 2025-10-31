<?php

class UmengUappGetNewAccountsResult
{
    private $newAccountInfo;

    private $stdResult;

    /**
     * @return UmengUappAccountInfo[]
     */
    public function getNewAccountInfo()
    {
        return $this->newAccountInfo;
    }

    /**
     * 设置UmengUappAccountInfo[]
     *
     * @param UmengUappAccountInfo[] $newAccountInfo
     * 此参数必填     */
    public function setNewAccountInfo(array $newAccountInfo)
    {
        $this->newAccountInfo = $newAccountInfo;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'newAccountInfo')) {
            $newAccountInfoResult = $this->stdResult->newAccountInfo;
            $object = json_decode(json_encode($newAccountInfoResult), true);
            $this->newAccountInfo = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappAccountInfoResult = new UmengUappAccountInfo();
                $UmengUappAccountInfoResult->setArrayResult($arrayobject);
                $this->newAccountInfo[$i] = $UmengUappAccountInfoResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('newAccountInfo')) {
            $newAccountInfoResult = $arrayResult['newAccountInfo'];
            $this->newAccountInfo = new UmengUappAccountInfo();
            $this->newAccountInfo->setStdResult($newAccountInfoResult);
        }
    }
}
