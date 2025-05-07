<?php

class UmengUappGetNewUsersResult
{
    private $newUserInfo;

    private $stdResult;

    private $arrayResult;

    /**
     * @return umeng.uapp.count.Data[]
     */
    public function getNewUserInfo()
    {
        return $this->newUserInfo;
    }

    /**
     * 设置umeng.uapp.count.Data[]
     *
     * @param array include @see UmengUappCountData[] $newUserInfo
     * 此参数必填     */
    public function setNewUserInfo(UmengUappCountData $newUserInfo)
    {
        $this->newUserInfo = $newUserInfo;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'newUserInfo')) {
            $newUserInfoResult = $this->stdResult->{'newUserInfo'};
            $object = json_decode(json_encode($newUserInfoResult), true);
            $this->newUserInfo = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappCountDataResult = new UmengUappCountData();
                $UmengUappCountDataResult->setArrayResult($arrayobject);
                $this->newUserInfo[$i] = $UmengUappCountDataResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('newUserInfo')) {
            $newUserInfoResult = $arrayResult['newUserInfo'];
            $this->newUserInfo = new UmengUappCountData();
            $this->newUserInfo->setStdResult($newUserInfoResult);
        }
    }
}
