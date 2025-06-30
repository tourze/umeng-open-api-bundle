<?php

class APIRequest
{
    /**
     * @var APIId
     */
    public $apiId;

    /**
     * @var array<string, mixed>
     */
    public $addtionalParams = [];

    /**
     * @var object|null Request parameter object
     */
    public $requestEntity;

    /**
     * @var array<string, mixed>
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
