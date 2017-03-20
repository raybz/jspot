<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-oauth',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'oauth\controllers',
    'defaultRoute' => 'oauth/index',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'myserver' => [
                    'class' => 'yii\authclient\OAuth2',
                    'clientId' => 'unique client_id',
                    'clientSecret' => 'client_secret',
                    'tokenUrl' => 'http://oauth.yii.com/token',
                    'authUrl' => 'http://oauth.yii.com/',
                    'apiBaseUrl' => 'http://myserver.local/api',
                ],
            ],
        ],

        'request' => [
            'csrfParam' => '_csrf-oauth',
        ],
        'user' => [
            'identityClass' => 'common\models\AdminUser',
            'enableAutoLogin' => true,
//            'loginUrl' => null,
//            'enableSession' => false,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-oauth',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'authorize' => 'oauth/index',
                'token' => 'oauth/token',
            ],
        ],
    ],
    'params' => $params,
];
