<?php

use frontend\models\EstadoProducto;
use frontend\models\Proveedor;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-index">
 
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (Yii::$app->user->can('r-proveedor') and !Yii::$app->user->can('r-administrador-jagao'))
            echo Html::a('Crear producto', ['create'], ['class' => 'btn btn-success'])
            ?>
    </p>

  


    <?php



    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'cantidad_stock',
            
            [
                'attribute' => 'proveedor_id',
                'value' => function ($data) {
                    return $data->proveedor->nombre;
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map( Yii::$app->user->can('r-administrador-jagao') ? Proveedor::find()->all() : Proveedor::find()->where(['usuario_id' => Yii::$app->user->id])->all(), 'id', 'nombre'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],           
            [
                'attribute' => 'estado_producto_id',
                'value' => function ($data) {
                    switch ($data->estado_producto_id) {
                        case 1:
                            return '<label class="label label-success">' . $data->estadoProducto->descripcion . '</label>';
                            break;
                        case 2:
                            return '<label class="label label-warning">' . $data->estadoProducto->descripcion . '</label>';
                            break;
                        case 3:
                            return '<label class="label label-danger">' . $data->estadoProducto->descripcion . '</label>';
                            break;
                        default:
                            return '<label class="label label-primary">' . $data->estadoProducto->descripcion . '</label>';    
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(EstadoProducto::find()->all(), 'id', 'descripcion'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view}{update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>     ', $url, [
                            'title' => Yii::t('app', 'Ver'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        if (Yii::$app->user->can('r-proveedor') and !Yii::$app->user->can('r-administrador-jagao')) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>       ', $url, [
                                'title' => Yii::t('app', 'Actualizar'),
                            ]);
                        }
                    },
                ]
            ],
            [
                'header' => 'Cambiar <br> Estado',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{inactivar}',
                'buttons' => [
                    'inactivar' => function ($url, $model) {
                        switch ($model->estado_producto_id) {
                            case '1':
                                return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', ['inactivar', 'id' => $model->id], [
                                    'class' => '',
                                    'title' => 'Inactivar',
                                    'data' => [
                                        'confirm' => '¿Está seguro que desea inactivar este producto?',
                                        'method' => 'post',
                                    ],
                                ]);
                                break;
                            case '5':
                                return Html::a('<span class="glyphicon glyphicon-ok"></span>', ['activar', 'id' => $model->id], [
                                    'class' => '',
                                    'title' => 'Activar',
                                    'data' => [
                                        'confirm' => '¿Está seguro que desea activar este producto?',
                                        'method' => 'post',
                                    ],
                                ]);
                                break;
                        }
                    },
                ]
            ]
        ],
    ]); ?>


</div>