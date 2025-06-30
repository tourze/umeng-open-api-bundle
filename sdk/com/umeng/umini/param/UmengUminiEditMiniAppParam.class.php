<?php

class UmengUminiEditMiniAppParam
{
    private $sdkStdResult = [];

    /**
     * @return mixed 数据源id（AppKey）
     */
    public function getDataSourceId()
    {
        $tempResult = $this->sdkStdResult['dataSourceId'];

        return $tempResult;
    }

    /**
     * 设置数据源id（AppKey）
     *
     * @param string $dataSourceId
     *                             参数示例：<pre>5e8c6dea978eea071c37c682</pre>
     * 此参数必填     */
    public function setDataSourceId($dataSourceId)
    {
        $this->sdkStdResult['dataSourceId'] = $dataSourceId;
    }

    /**
     * @return string 平台(不可编辑)
     */
    public function getPlatform()
    {
        $tempResult = $this->sdkStdResult['platform'];

        return $tempResult;
    }

    /**
     * 设置平台(不可编辑)
     *
     * @param string $platform
     *                         参数示例：<pre>mini_wechat</pre>
     *                         此参数为可选参数
     *                         默认值：<pre></pre>
     */
    public function setPlatform($platform)
    {
        $this->sdkStdResult['platform'] = $platform;
    }

    /**
     * @return string 应用名称
     */
    public function getName()
    {
        $tempResult = $this->sdkStdResult['name'];

        return $tempResult;
    }

    /**
     * 设置应用名称
     *
     * @param string $name
     *                     参数示例：<pre>应用名称</pre>
     *                     此参数为可选参数
     *                     默认值：<pre></pre>
     */
    public function setName($name)
    {
        $this->sdkStdResult['name'] = $name;
    }

    /**
     * @return mixed 语言(CN:中文; OTHER:其他)
     */
    public function getLanguage()
    {
        $tempResult = $this->sdkStdResult['language'];

        return $tempResult;
    }

    /**
     * 设置语言(CN:中文; OTHER:其他)
     *
     * @param string $language
     *                         参数示例：<pre>CN</pre>
     *                         此参数为可选参数
     *                         默认值：<pre></pre>
     */
    public function setLanguage($language)
    {
        $this->sdkStdResult['language'] = $language;
    }

    /**
     * @return mixed 一级分类（行业帮助文档：https://developer.umeng.com/docs/147615/detail/169442 ）
     */
    public function getFirstLevel()
    {
        $tempResult = $this->sdkStdResult['firstLevel'];

        return $tempResult;
    }

    /**
     * 设置一级分类（行业帮助文档：https://developer.umeng.com/docs/147615/detail/169442 ）
     *
     * @param string $firstLevel
     *                           参数示例：<pre>公共交通与出行</pre>
     *                           此参数为可选参数
     *                           默认值：<pre></pre>
     */
    public function setFirstLevel($firstLevel)
    {
        $this->sdkStdResult['firstLevel'] = $firstLevel;
    }

    /**
     * @return mixed 二级分类
     */
    public function getSecondLevel()
    {
        $tempResult = $this->sdkStdResult['secondLevel'];

        return $tempResult;
    }

    /**
     * 设置二级分类
     *
     * @param string $secondLevel
     *                            参数示例：<pre>公共交通</pre>
     *                            此参数为可选参数
     *                            默认值：<pre></pre>
     */
    public function setSecondLevel($secondLevel)
    {
        $this->sdkStdResult['secondLevel'] = $secondLevel;
    }

    /**
     * @return mixed 描述
     */
    public function getDescription()
    {
        $tempResult = $this->sdkStdResult['description'];

        return $tempResult;
    }

    /**
     * 设置描述
     *
     * @param string $description
     *                            参数示例：<pre>描述……</pre>
     *                            此参数为可选参数
     *                            默认值：<pre></pre>
     */
    public function setDescription($description)
    {
        $this->sdkStdResult['description'] = $description;
    }

    /**
     * @return array 微信/支付宝AppId（不可单独出现，需要和下面参数组队出现）
     */
    public function getMiniAppId()
    {
        $tempResult = $this->sdkStdResult['miniAppId'];

        return $tempResult;
    }

    /**
     * 设置微信/支付宝AppId（不可单独出现，需要和下面参数组队出现）
     *
     * @param string $miniAppId
     *                          参数示例：<pre></pre>
     *                          此参数为可选参数
     *                          默认值：<pre></pre>
     */
    public function setMiniAppId($miniAppId)
    {
        $this->sdkStdResult['miniAppId'] = $miniAppId;
    }

    /**
     * @return mixed 微信AppSecret（miniAppId和miniAppSecret必须成对出现）
     */
    public function getMiniAppSecret()
    {
        $tempResult = $this->sdkStdResult['miniAppSecret'];

        return $tempResult;
    }

    /**
     * 设置微信AppSecret（miniAppId和miniAppSecret必须成对出现）
     *
     * @param string $miniAppSecret
     *                              参数示例：<pre></pre>
     *                              此参数为可选参数
     *                              默认值：<pre></pre>
     */
    public function setMiniAppSecret($miniAppSecret)
    {
        $this->sdkStdResult['miniAppSecret'] = $miniAppSecret;
    }

    /**
     * @return mixed 支付宝PublicKey（miniAppId、miniPublicKey和miniPrivateKey必须同时出现）
     */
    public function getMiniPublicKey()
    {
        $tempResult = $this->sdkStdResult['miniPublicKey'];

        return $tempResult;
    }

    /**
     * 设置支付宝PublicKey（miniAppId、miniPublicKey和miniPrivateKey必须同时出现）
     *
     * @param string $miniPublicKey
     *                              参数示例：<pre></pre>
     *                              此参数为可选参数
     *                              默认值：<pre></pre>
     */
    public function setMiniPublicKey($miniPublicKey)
    {
        $this->sdkStdResult['miniPublicKey'] = $miniPublicKey;
    }

    /**
     * @return mixed 支付宝PrivateKey（miniAppId、miniPublicKey和miniPrivateKey必须同时出现）
     */
    public function getMiniPrivateKey()
    {
        $tempResult = $this->sdkStdResult['miniPrivateKey'];

        return $tempResult;
    }

    /**
     * 设置支付宝PrivateKey（miniAppId、miniPublicKey和miniPrivateKey必须同时出现）
     *
     * @param string $miniPrivateKey
     *                               参数示例：<pre></pre>
     *                               此参数为可选参数
     *                               默认值：<pre></pre>
     */
    public function setMiniPrivateKey($miniPrivateKey)
    {
        $this->sdkStdResult['miniPrivateKey'] = $miniPrivateKey;
    }

    /**
     * @return string 集成类型；单应用小程序集成：single、小程序模版类应用集成 ：template
     */
    public function getIntegrationType()
    {
        $tempResult = $this->sdkStdResult['integrationType'];

        return $tempResult;
    }

    /**
     * 设置集成类型；单应用小程序集成：single、小程序模版类应用集成 ：template
     *
     * @param string $integrationType
     *                                参数示例：<pre>single</pre>
     *                                此参数为可选参数
     *                                默认值：<pre>single</pre>
     */
    public function setIntegrationType($integrationType)
    {
        $this->sdkStdResult['integrationType'] = $integrationType;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
