<?php

class UmengUappEventGetUniqueUsersResult
{
    private $uniqueUsers;

    private $stdResult;

    public function getUniqueUsers()
    {
        return $this->uniqueUsers;
    }

    /**
     * 设置
     *
     * @param UmengUappDateCountInfo[] $uniqueUsers
     * 此参数必填     */
    public function setUniqueUsers(array $uniqueUsers)
    {
        $this->uniqueUsers = $uniqueUsers;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'uniqueUsers')) {
            $uniqueUsersResult = $this->stdResult->uniqueUsers;
            $object = json_decode(json_encode($uniqueUsersResult), true);
            $this->uniqueUsers = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappDateCountInfoResult = new UmengUappDateCountInfo();
                $UmengUappDateCountInfoResult->setArrayResult($arrayobject);
                $this->uniqueUsers[$i] = $UmengUappDateCountInfoResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('uniqueUsers')) {
            $uniqueUsersResult = $arrayResult['uniqueUsers'];
            $this->uniqueUsers = new UmengUappDateCountInfo();
            $this->uniqueUsers->setStdResult($uniqueUsersResult);
        }
    }
}
