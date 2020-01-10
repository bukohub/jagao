<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\TipoReporteProducto */

$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Reporte Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tipo-reporte-producto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion:ntext',
            [
                'attribute' => 'creado_por',
                'value' => $model->creadoPor->username
            ],
            'creado_el',
            [
                'attribute' => 'actualizado_por',
                'value' => $model->actualizadoPor->username
            ],
            'actualizado_el',
        ],
    ]) ?>

</div>
