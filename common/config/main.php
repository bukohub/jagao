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
            'rules' => array(
                    '/carrito' => '/producto/list-cart',
                    '/checkout' => '/informacion-compra/create',
                    '/tienda/<proveedor:.+>' => 'producto/lista-jagao',
                    '/p/<idProducto:.+>/<nombre:.+>' => 'producto/detalle-producto',
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\.+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',                    
            ),
        ],
    ],
];
