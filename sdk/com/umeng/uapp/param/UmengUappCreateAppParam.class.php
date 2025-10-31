<?php

class UmengUappCreateAppParam
{
    private $sdkStdResult = [];

    /**
     * @return string 名称
     */
    public function getName()
    {
        return $this->sdkStdResult['name'];
    }

    /**
     * 设置名称
     *
     * @param string $name
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setName($name)
    {
        $this->sdkStdResult['name'] = $name;
    }

    /**
     * @return string 类型
     */
    public function getType()
    {
        return $this->sdkStdResult['type'];
    }

    /**
     * 设置类型
     *
     * @param string $type
     *                     参数示例：<pre>app:应用;</pre>
     * 此参数必填     */
    public function setType($type)
    {
        $this->sdkStdResult['type'] = $type;
    }

    /**
     * @return string 平台
     */
    public function getPlatform()
    {
        return $this->sdkStdResult['platform'];
    }

    /**
     * 设置平台
     *
     * @param string $platform
     *                         参数示例：<pre>iphone:iPhone; ipad:iPad; android:Android; wphone:WinPhone; h5app:HTML5;</pre>
     * 此参数必填     */
    public function setPlatform($platform)
    {
        $this->sdkStdResult['platform'] = $platform;
    }

    /**
     * @return mixed 语言
     */
    public function getLanguage()
    {
        return $this->sdkStdResult['language'];
    }

    /**
     * 设置语言
     *
     * @param string $language
     *                         参数示例：<pre>CN:中文; OTHER:其他</pre>
     * 此参数必填     */
    public function setLanguage($language)
    {
        $this->sdkStdResult['language'] = $language;
    }

    /**
     * @return mixed 一级分类，帮助文档：https://developer.umeng.com/docs/119267/detail/183761
     */
    public function getFirstLevel()
    {
        return $this->sdkStdResult['firstLevel'];
    }

    /**
     * 设置一级分类，帮助文档：https://developer.umeng.com/docs/119267/detail/183761
     *
     * @param string $firstLevel
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setFirstLevel($firstLevel)
    {
        $this->sdkStdResult['firstLevel'] = $firstLevel;
    }

    /**
     * @return mixed 二级分类，帮助文档同上
     */
    public function getSecondLevel()
    {
        return $this->sdkStdResult['secondLevel'];
    }

    /**
     * 设置二级分类，帮助文档同上
     *
     * @param string $secondLevel
     *                            参数示例：<pre></pre>
     * 此参数必填     */
    public function setSecondLevel($secondLevel)
    {
        $this->sdkStdResult['secondLevel'] = $secondLevel;
    }

    /**
     * @return mixed 描述
     */
    public function getDescription()
    {
        return $this->sdkStdResult['description'];
    }

    /**
     * 设置描述
     *
     * @param string $description
     *                            参数示例：<pre></pre>
     *                            此参数为可选参数
     *                            默认值：<pre></pre>
     */
    public function setDescription($description)
    {
        $this->sdkStdResult['description'] = $description;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
