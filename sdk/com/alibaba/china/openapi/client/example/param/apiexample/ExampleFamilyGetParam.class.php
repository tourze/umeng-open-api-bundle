<?php

class ExampleFamilyGetParam
{
    private $sdkStdResult = [];

    /**
     * @return mixed 可接受参数1或者2，其余参数无法找到family对象
     */
    public function getFamilyNumber()
    {
        $tempResult = $this->sdkStdResult['familyNumber'];

        return $tempResult;
    }

    /**
     * 设置可接受参数1或者2，其余参数无法找到family对象
     *
     * @param int $familyNumber
     *                          参数示例：<pre></pre>
     *                          此参数必填
     */
    public function setFamilyNumber($familyNumber)
    {
        $this->sdkStdResult['familyNumber'] = $familyNumber;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
