<?php

/**
 * 友盟 SDK 自动加载器
 */
spl_autoload_register(function ($class): void {
    // 将类名转换为文件路径
    $classFile = __DIR__ . '/com/' . str_replace('\\', '/', $class) . '.class.php';

    // 检查基本类文件
    if (!file_exists($classFile)) {
        // 尝试不带 com 前缀的路径
        $classFile = __DIR__ . '/' . $class . '.class.php';
    }

    // 如果文件存在，则加载
    if (file_exists($classFile)) {
        require_once $classFile;
    }
});

// 加载一些常用类的映射
$classMap = [
    'HttpClient' => __DIR__ . '/HttpClient.class.php',
    'ExampleFacade' => __DIR__ . '/com/alibaba/china/openapi/client/example/ExampleFacade.class.php',
    'ExampleFamily' => __DIR__ . '/com/alibaba/china/openapi/client/example/param/apiexample/ExampleFamily.class.php',
    'ExamplePerson' => __DIR__ . '/com/alibaba/china/openapi/client/example/param/apiexample/ExamplePerson.class.php',
    'ExampleFamilyGetParam' => __DIR__ . '/com/alibaba/china/openapi/client/example/param/apiexample/ExampleFamilyGetParam.class.php',
    'ExampleFamilyGetResult' => __DIR__ . '/com/alibaba/china/openapi/client/example/param/apiexample/ExampleFamilyGetResult.class.php',
    'ExampleFamilyPostParam' => __DIR__ . '/com/alibaba/china/openapi/client/example/param/apiexample/ExampleFamilyPostParam.class.php',
    'ExampleFamilyPostResult' => __DIR__ . '/com/alibaba/china/openapi/client/example/param/apiexample/ExampleFamilyPostResult.class.php',
    'ByteArray' => __DIR__ . '/com/alibaba/openapi/client/entity/ByteArray.class.php',
    'OceanException' => __DIR__ . '/com/alibaba/openapi/client/exception/OceanException.class.php',
    'AuthorizationToken' => __DIR__ . '/com/alibaba/openapi/client/entity/AuthorizationToken.class.php',
    'RequestPolicy' => __DIR__ . '/com/alibaba/openapi/client/policy/RequestPolicy.class.php',
    'ClientPolicy' => __DIR__ . '/com/alibaba/openapi/client/policy/ClientPolicy.class.php',
    'DataProtocol' => __DIR__ . '/com/alibaba/openapi/client/policy/DataProtocol.class.php',
    'APIRequest' => __DIR__ . '/com/alibaba/openapi/client/APIRequest.class.php',
    'APIId' => __DIR__ . '/com/alibaba/openapi/client/APIId.class.php',
    'SyncAPIClient' => __DIR__ . '/com/alibaba/openapi/client/SyncAPIClient.class.php',
];

// 注册类映射自动加载
spl_autoload_register(function ($class) use ($classMap): void {
    if (isset($classMap[$class])) {
        require_once $classMap[$class];
    }
});
