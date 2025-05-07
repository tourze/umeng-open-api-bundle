<?php

class UmengUappGetNewAccountsResult
{
    private $newAccountInfo;

    private $stdResult;

    private $arrayResult;

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
     * @param array include @see UmengUappAccountInfo[] $newAccountInfo
     * 此参数必填     */
    public function setNewAccountInfo(UmengUappAccountInfo $newAccountInfo)
    {
        $this->newAccountInfo = $newAccountInfo;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'newAccountInfo')) {
            $newAccountInfoResult = $this->stdResult->{'newAccountInfo'};
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
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('newAccountInfo')) {
            $newAccountInfoResult = $arrayResult['newAccountInfo'];
            $this->newAccountInfo = new UmengUappAccountInfo();
            $this->newAccountInfo->setStdResult($newAccountInfoResult);
        }
    }
}
