<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'class' => 'yii\web\Session',
            'name' => 'advanced-frontend', 
            'cookieParams' => ['lifetime' => 12 *60 * 60],
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
        'authManager'=>
        [
            'class'=>'yii\rbac\DbManager',
            'defaultRoles' => ['NONE'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
       /* 'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],*/
        
        'urlManagerBackEnd' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '/fts/backend/web',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'urlManagerUser' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '/fts/backend/web/index.php?r=user',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'sms' => [
        'class' => 'darkunz\yii2sms\Twilio',
        'sid' => '**********',
        'token' => '********',
        'number' => '*********',
    ],
        
    ],
    
    'modules' => [
       'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ]
    ],
    
    'params' => $params,
    'defaultRoute' => 'site/index',
];
