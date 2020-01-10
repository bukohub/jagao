<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\models\EstadoCompra;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductoComprasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis Compras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-compras-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php
    $columnIna = [
        'header' => 'Ver Detalle',
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'lead-view'),
                ]);
            },
        ]
    ];
    
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => 'Pendiente'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'codigo_factura',
            [
                'attribute' => 'numero_guia',
                'label' => 'Num. Guía',
                'format' => 'raw',
                'value' => function ($data) {
                    if(!empty($data->nombre_archivo))
                    return Html::a($data->numero_guia,  Yii::$app->urlManager->createUrl('..' . Yii::$app->params['rutaImagenesSeguimiento'] . $data->nombre_archivo),['target'=>'_blank']);
                    else
                    return $data->numero_guia;
                },
            ],
            'nombre_transportadora',
            [
                'attribute' => 'producto_id',
                'value' => function ($data) {
                    return $data->producto->nombre;
                }
            ],
       
            [
                'attribute' => 'estado_id',
                'value' => function ($data) {
                    switch ($data->estado_id) {
                        case 1:
                            return '<label class="label label-success">' . $data->estado->descripcion . '</label>';
                            break;
                        case 2:
                            return '<label class="label label-danger">' . $data->estado->descripcion . '</label>';
                            break;
                        case 3:
                            return '<label class="label label-warning">' . $data->estado->descripcion . '</label>';
                            break;
                        case 4:
                            return '<label class="label label-primary">' . $data->estado->descripcion . '</label>';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(EstadoCompra::find()->all(), 'id', 'descripcion'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            [
                'attribute' => 'user_id',
                'value' => function ($data) {
                    return $data->user->username;
                }
            ],


            'creado_el',
            $columnIna




        ],
    ]); ?>


</div>