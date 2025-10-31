<?php

class UmengUappGetActiveUsersResult
{
    private $activeUserInfo;

    private $stdResult;

    /**
     * @return umeng.uapp.count.Data[]
     */
    public function getActiveUserInfo()
    {
        return $this->activeUserInfo;
    }

    /**
     * 设置umeng.uapp.count.Data[]
     *
     * @param UmengUappCountData[] $activeUserInfo
     * 此参数必填     */
    public function setActiveUserInfo(array $activeUserInfo)
    {
        $this->activeUserInfo = $activeUserInfo;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'activeUserInfo')) {
            $activeUserInfoResult = $this->stdResult->activeUserInfo;
            $object = json_decode(json_encode($activeUserInfoResult), true);
            $this->activeUserInfo = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappCountDataResult = new UmengUappCountData();
                $UmengUappCountDataResult->setArrayResult($arrayobject);
                $this->activeUserInfo[$i] = $UmengUappCountDataResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('activeUserInfo')) {
            $activeUserInfoResult = $arrayResult['activeUserInfo'];
            $this->activeUserInfo = new UmengUappCountData();
            $this->activeUserInfo->setStdResult($activeUserInfoResult);
        }
    }
}
