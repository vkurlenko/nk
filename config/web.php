<?php
use yii\web\UrlNormalizer;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout'=> 'main',
            /*'user' => [
                'identityClass' => 'app\models\User',
                'enableAutoLogin' => true,
                //'loginUrl' => ['admin/default/login'],
            ],*/
        ],
        'yii2images' => [
            'class' => 'rico\yii2images\Module',
            //be sure, that permissions ok
            //if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
            'imagesStorePath' => 'upload/store', //path to origin images
            'imagesCachePath' => 'upload/cache', //path to resized copies
            'graphicsLibrary' => 'GD', //but really its better to use 'Imagick'
            //'imagesStorePath' => '@webroot/upload/store', //path to origin images
            //'imagesCachePath' => '@webroot/upload/cache', //path to resized copies
            'placeHolderPath' => '@webroot/upload/store/no-image.png', // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
            'imageCompressionQuality' => 85, // Optional. Default value is 85.
        ],
    ],




    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\jui\JuiAsset' => [
                    'css' => [
                        'themes/base/jquery-ui.css?v=1',
                    ]
                ]
            ]
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'DB7K1R3Eljg5DK_zI-kE9uVCBQM9_Apv',
            'baseUrl'=> '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LfanGEUAAAAAFIS5OyAFgrlAvnbt9nSRnTHP1sA',
            'secret' => '6LfanGEUAAAAAK0CHtHFopiAzIzmGoKK4H3LX3qK',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            //'loginUrl' => ['site/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'narodny.konditer@yandex.ru',
                'password' => 'konditer',
                'port' => '465',
                'encryption' => 'ssl',
            ],
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
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'suffix'    => '/',
           /* 'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                'action' => UrlNormalizer::ACTION_REDIRECT_TEMPORARY, // используем временный редирект вместо постоянного
            ],*/
            'rules' => [
                '/' => 'site/index',
                'yandex_dc3953a6cade32e5.html' => 'http://nk/yandex_dc3953a6cade32e5.html',
                //'<action:\w+>' => 'site/<action>',
                //'<action:(person)>/' => 'site/<action>',
                'admin' => 'admin/default/index',

                'sitemap.xml' => 'sitemap/index',

                '<action:(supervision|jury|franch|casting)>/' => 'site/<action>',

                'contact' => 'site/contact',

                'markets' => 'site/markets',
                //'markets/<id:\d+>' => 'site/markets',
                'markets/<id:[a-z0-9_\-()]+>' => 'site/markets',
                'markets/<id:[a-z0-9_\-()]+>/' => 'site/markets',

                /*'gde' => 'where/index',
                'gde/<city:[a-z0-9_\-()]+>' => 'where/index',*/

               /* 'where' => 'where/index',
                'where/<city:[a-z0-9_\-()]+>' => 'where/index',*/




                /*[
                    'pattern' => 'gde',
                    'route' => 'where/index',
                ],
                [
                    'pattern' => 'gde/<city:[a-z0-9_\-()]+>',
                    'route' => 'where/index',
                ],*/

                /*'gde' => 'site/where',
                'gde/<city:[a-z0-9_\-()]+>' => 'where/index',*/

                'products' => 'products',
                //'product/<id:\d+>' => 'products/product',
                'products/<cat:[a-z0-9_\-()]+>/' => 'products/',
                'product/<id:[a-z0-9_\-()]+>' => 'products/product',

                //'person/<id: >' => 'person/person',
                //'person' => 'person/person',

                'person<^\/$>' => 'person/person',
                [
                    'pattern' => 'person/<id:[a-z0-9_\-()]+>',
                    'route' => 'person/index',
                    //'mode' =>  \yii\web\UrlRule::PARSING_ONLY
                ],

                'persons/<year:\d+>' => 'person/person',
                'persons' => 'person/person',
                //'persons/' => 'person/person',

                [
                    'class' => 'app\components\MyUrlRule',
                ],

                '<action:\w+>' => 'site/text',

                //'defaultRoute' => 'site/text',
                //'about' => 'site/about',

                //'admin/pages' => 'admin/pages',                              
                //'<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
        
    ],

    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['@'],
            'root' => [
                'path' => 'upload/global',
                'name' => 'Global'
            ],
        ]
    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
