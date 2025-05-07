<?php

class APIRequest
{
    /**
     * @var APIId
     */
    public $apiId;

    /**
     * @var map
     */
    public $addtionalParams = [];

    /**
     * @var base on request parameter object
     */
    public $requestEntity;

    /**
     * @var map
     */
    public $attachments = [];

    /**
     * @var string
     */
    public $authCodeKey;

    /**
     * @var string
     */
    public $accessToken;

    /**
     * @var AuthorizationToken
     */
    public $authToken;
}
