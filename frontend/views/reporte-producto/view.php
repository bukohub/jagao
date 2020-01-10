<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReporteProducto */

$this->title = $model->tipoReporteProducto->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Reportes productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reporte-producto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'tipo_reporte_producto_id',
                'value' => $model->tipoReporteProducto->descripcion
            ],
            'descripcion:ntext',
            [
                'attribute' => 'producto_id',
                'value' => $model->producto->nombre,
                'label' => 'Producto'
            ],
            [
                'attribute' => 'creado_por',
                'value' => $model->creadoPor->username
            ],
        ],
    ]) ?>

</div>
