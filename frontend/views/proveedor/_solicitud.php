<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\models\Estado;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProveedorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estado de solicitud para ofertar mis productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proveedor-index">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php
    $columnaAcciones = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view}{update}{delete}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => 'Ver',
                ]);
            },
            'update' => function ($url, $model) {
                if ($model->estado_id == 3 || Yii::$app->user->can('r-administrador-jagao')) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => 'Actualizar',
                    ]);
                }
            },
        ]
    ];

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'identificacion_nit',
            [
                'attribute' => 'usuario_id',
                'value' => function ($data) {
                    return $data->creadoPor->username;
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
                'filter' => ArrayHelper::map(Estado::find()->all(), 'id', 'descripcion'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            $columnaAcciones,
        ],
    ]);
    ?>
</div>
