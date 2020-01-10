<?php

use frontend\models\EstadoPregunta;
use frontend\models\Producto;
use frontend\models\Proveedor;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PreguntaProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pregunta-producto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $columnaAcciones = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view}{delete}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>         ', $url, [
                            'title' => 'Ver',
                ]);
            },
            'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title'        => 'Eliminar',
                        'data-confirm' => Yii::t('yii', '¿Está seguro que desea eliminar la pregunta?'),
                        'data-method'  => 'post',
                    ]);             
            }
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
                    return $data->producto->nombre;
                },                
            ],
            [
                'attribute' => 'estado_pregunta_id',
                'value' => function ($data) {
                    switch ($data->estado_pregunta_id) {
                        case 1:
                            return '<label class="label label-primary">' . $data->estadoPregunta->descripcion . '</label>';
                            break;
                        case 2:
                            return '<label class="label label-danger">' . $data->estadoPregunta->descripcion . '</label>';
                            break;
                        case 3:
                            return '<label class="label label-success">' . $data->estadoPregunta->descripcion . '</label>';
                            break;
                        default:
                            return '<label class="label label-primary">' . $data->estadoPregunta->descripcion . '</label>';    
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(EstadoPregunta::find()->all(), 'id', 'descripcion'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            [
                'attribute' => 'creado_por',
                'label' => 'Usuario',
                'value' => function($data) {
                    return $data->creadoPor->username;
                }
            ],
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            $columnaAcciones,
        ],
    ]);
    ?>


</div>
