<?php

use frontend\models\Producto;
use frontend\models\Proveedor;
use jino5577\daterangepicker\DateRangePicker;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductoCalificacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-calificacion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    $columnIna = [
        'header' => 'Calificar Producto',
        'visible' => $button,
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{calificar}',
        'visible'=>$calif,
        'buttons' => [
            'calificar' => function ($url, $model) {
                return Html::a('<span class="fa fa-thumbs-up"></span>', ['create', 'id' => $model->id], [
                    'class' => '',
                    'title' => 'Calificar un Producto',
                    'data' => [
                        'method' => 'post',
                    ],
                ]);
            },
        ]
    ];
    


    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'producto_id',
                'value' => function ($data) {
                    return @$data->producto->nombre;
                },              
            ], 
            [
                'attribute' => 'calificacion',
                'value' => function ($data) {
                    return ($data->calificacion==NULL) ? 'Pendiente calificación' : $data->calificacion;
                }
            ],
            [
                'attribute' => 'creado_por',
                'label'=>'Calificado Por',
                'value' => function ($data) {
                    return @$data->creadoPor->username;
                }
            ],
            [
                'attribute' => 'creado_el',
                'value' => function ($model) {
                        return date('Y-m-d G:i:s', strtotime($model->creado_el));
                },
                'headerOptions' => [
                    'class' => 'col-md-2'
                ],
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'creado_el_rango',
                    'pluginOptions' => [
                    'format' => 'd-m-Y',
                    'autoUpdateInput' => false
                ]
                ])
            ],
            //'actualizado_por',
            //'actualizado_el',
            $columnIna,
          
        ],
    ]); ?>


</div>