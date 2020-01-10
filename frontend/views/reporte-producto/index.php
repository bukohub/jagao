<?php

use frontend\models\TipoReporteProducto;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ReporteProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reportes de productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reporte-producto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'tipo_reporte_producto_id',
                'value' => function ($data) {
                    return $data->tipoReporteProducto->descripcion;
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map( TipoReporteProducto::find()->all(), 'id', 'descripcion'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            [
                'attribute' => 'producto_id',
                'value' => function($data) {
                    return $data->producto->nombre;
                },
                        'label' => 'Producto'
            ],
            [
                'attribute' => 'creado_por',
                'value' => function($data) {
                    return $data->creadoPor->username;
                },
            ],
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => 'Ver',
                        ]);
                    },
                ]
            ],
        ],
    ]);
    ?>


</div>
