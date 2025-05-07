<?php

class SignatureUtil
{
    /**
     * @param unknown $path
     * @return string
     */
    public static function signature($path, array $parameters, RequestPolicy $requestPolicy, ClientPolicy $clientPolicy)
    {
        $paramsToSign = [];
        foreach ($parameters as $k => $v) {
            $paramToSign = $k . $v;
            array_push($paramsToSign, $paramToSign);
        }
        sort($paramsToSign);
        $implodeParams = implode($paramsToSign);
        $pathAndParams = $path . $implodeParams;
        $sign = hash_hmac('sha1', $pathAndParams, $clientPolicy->secKey, true);
        $signHexWithLowcase = bin2hex($sign);
        $signHexUppercase = mb_strtoupper($signHexWithLowcase);

        return $signHexUppercase;
    }
}
