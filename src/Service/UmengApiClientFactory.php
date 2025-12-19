<?php

declare(strict_types=1);

namespace UmengOpenApiBundle\Service;

use UmengOpenApiBundle\Entity\Account;

final class UmengApiClientFactory
{
    public function createClient(Account $account): \SyncAPIClient
    {
        $clientPolicy = new \ClientPolicy(
            $account->getApiKey(),
            $account->getApiSecurity(),
            'gateway.open.umeng.com'
        );

        return new \SyncAPIClient($clientPolicy);
    }

    public function createRequestPolicy(): \RequestPolicy
    {
        $reqPolicy = new \RequestPolicy();
        $reqPolicy->httpMethod = 'POST';
        $reqPolicy->needAuthorization = false;
        $reqPolicy->requestSendTimestamp = false;
        $reqPolicy->useHttps = true;
        $reqPolicy->useSignture = true;
        $reqPolicy->accessPrivateApi = false;

        return $reqPolicy;
    }
}
