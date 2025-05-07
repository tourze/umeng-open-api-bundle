<?php

class UmengUappGetActiveAccountsResult
{
    private $activeAccountInfo;

    private $stdResult;

    private $arrayResult;

    public function getActiveAccountInfo()
    {
        return $this->activeAccountInfo;
    }

    /**
     * 设置
     *
     * @param array include @see UmengUappActiveAccountInfo[] $activeAccountInfo
     * 此参数必填     */
    public function setActiveAccountInfo(UmengUappActiveAccountInfo $activeAccountInfo)
    {
        $this->activeAccountInfo = $activeAccountInfo;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'activeAccountInfo')) {
            $activeAccountInfoResult = $this->stdResult->{'activeAccountInfo'};
            $object = json_decode(json_encode($activeAccountInfoResult), true);
            $this->activeAccountInfo = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappActiveAccountInfoResult = new UmengUappActiveAccountInfo();
                $UmengUappActiveAccountInfoResult->setArrayResult($arrayobject);
                $this->activeAccountInfo[$i] = $UmengUappActiveAccountInfoResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('activeAccountInfo')) {
            $activeAccountInfoResult = $arrayResult['activeAccountInfo'];
            $this->activeAccountInfo = new UmengUappActiveAccountInfo();
            $this->activeAccountInfo->setStdResult($activeAccountInfoResult);
        }
    }
}
