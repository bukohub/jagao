<?php

return [
    'timeZone' => 'America/Bogota',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'es', // spanish
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'ayudante' => [
            'class' => 'common\components\Ayudante',
        ],
        'notificador' => [
            'class' => 'common\components\Notificador',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
          
        ],
    ],
];
