<?php

class ExampleFamilyPostParam
{
    private $sdkStdResult = [];

    /**
     * @return string 上传Family对象信息
     */
    public function getFamily()
    {
        return $this->sdkStdResult['family'];
    }

    /**
     * 设置上传Family对象信息
     *
     * @param ExampleFamily $family
     *                              参数示例：<pre></pre>
     *                              此参数必填
     */
    public function setFamily(ExampleFamily $family)
    {
        $this->sdkStdResult['family'] = $family;
    }

    /**
     * @return string 备注信息
     */
    public function getComments()
    {
        return $this->sdkStdResult['comments'];
    }

    /**
     * 设置备注信息
     *
     * @param string $comments
     *                         参数示例：<pre></pre>
     *                         此参数必填
     */
    public function setComments($comments)
    {
        $this->sdkStdResult['comments'] = $comments;
    }

    /**
     * @return string 房屋信息
     */
    public function getHouseImg()
    {
        return $this->sdkStdResult['houseImg'];
    }

    /**
     * 设置房屋信息
     *
     * @param array $houseImg Byte[] 参数示例：此参数必填
     */
    public function setHouseImg($houseImg)
    {
        $this->sdkStdResult['houseImg'] = $houseImg;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
