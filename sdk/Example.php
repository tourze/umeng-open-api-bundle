<?php

require_once __DIR__ . '/autoload.php';

$exampleFacade = new ExampleFacade();
$exampleFacade->setAppKey('Your appKey');
$exampleFacade->setSecKey('Your appSecret');
$exampleFacade->setServerHost('server host');
// you need change this refresh token when you run this example.
$testRefreshToken = '6291ea7b-8658-4cea-9e45-b880d66e2d11';

try {
    // --------------------------first example starting----------------------------------
    $param = new ExampleFamilyGetParam();
    $param->setFamilyNumber(1);
    $exampleFamilyGetResult = new ExampleFamilyGetResult();

    $exampleFacade->exampleFamilyGet($param, $exampleFamilyGetResult);
    $exampleFamily = $exampleFamilyGetResult->getResult();
    echo 'ExampleFamilyGet call get the result, the familyNumber is ';
    echo $exampleFamilyGetResult->getResult()->getFamilyNumber();
    echo ' and the name of father is ';
    $father = $exampleFamilyGetResult->getResult()->getFather();
    if (null !== $father) {
        echo $father->getName();
        echo ', the birthday of fanther is ';
        echo $father->getBirthday();
    }
    echo '<br/>';
    // ----------------------------first example end-------------------------------------

    // --------------------------second example starting----------------------------------
    $exampleFamilyPostParam = new ExampleFamilyPostParam();
    // set the simple parameter
    $exampleFamilyPostParam->setComments('SDK Example');

    // set a complex domain as parameter
    $exampleFamily = new ExampleFamily();

    $exampleFamily->setFamilyNumber(12);
    $exampleFather = new ExamplePerson();
    $exampleFather->setAge(31);
    $exampleFather->setBirthday('19780312101010000');
    $exampleFather->setName('John');
    $exampleFamily->setFather($exampleFather);
    $exampleFamilyPostParam->setFamily($exampleFamily);

    // simulate the feature of upload image.
    $fileContent = file_get_contents('example.png');
    $houseImg = new ByteArray();
    $houseImg->setBytesValue($fileContent);
    $exampleFamilyPostParam->setHouseImg([$houseImg->getBytesValue()]);

    $authorizationToken = $exampleFacade->refreshToken($testRefreshToken);
    echo 'refresh token:';
    echo $authorizationToken->getAccessToken();
    echo '<br/>';

    $exampleFamilyPostResult = new ExampleFamilyPostResult();
    $exampleFacade->exampleFamilyPost($exampleFamilyPostParam, $authorizationToken->getAccessToken(), $exampleFamilyPostResult);
    echo 'ExampleFamilyPost call get the result, the descriptin of result is ';
    echo $exampleFamilyPostResult->getResultDesc();
    echo '<br/>';
    echo 'ExampleFamilyPost call get the result, the father name upset is ';
    $resultFather = $exampleFamilyPostResult->getResult()->getFather();
    if (null !== $resultFather) {
        echo $resultFather->getName();
    }
    // --------------------------second example starting----------------------------------
} catch (OceanException $ex) {
    echo 'Exception occured with code[';
    echo $ex->getErrorCode();
    echo '] message [';
    echo $ex->getMessage();
    echo '].';
}
