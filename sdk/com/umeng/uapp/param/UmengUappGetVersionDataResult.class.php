<?php

class UmengUappGetVersionDataResult
{
    private $versionInfos;

    private $stdResult;

    public function getVersionInfos()
    {
        return $this->versionInfos;
    }

    /**
     * 设置
     *
     * @param UmengUappVersionInfo[] $versionInfos
     * 此参数必填     */
    public function setVersionInfos(array $versionInfos)
    {
        $this->versionInfos = $versionInfos;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'versionInfos')) {
            $versionInfosResult = $this->stdResult->versionInfos;
            $object = json_decode(json_encode($versionInfosResult), true);
            $this->versionInfos = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappVersionInfoResult = new UmengUappVersionInfo();
                $UmengUappVersionInfoResult->setArrayResult($arrayobject);
                $this->versionInfos[$i] = $UmengUappVersionInfoResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('versionInfos')) {
            $versionInfosResult = $arrayResult['versionInfos'];
            $this->versionInfos = new UmengUappVersionInfo();
            $this->versionInfos->setStdResult($versionInfosResult);
        }
    }
}
