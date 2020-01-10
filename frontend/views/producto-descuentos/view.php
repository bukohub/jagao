<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProductoDescuentos */

$this->title = $model->producto->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Producto Descuentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="producto-descuentos-view">

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
            [
                'attribute' => 'producto_id',
                'value' => $model->producto->nombre
            ],
            'descuento',
            [
                'attribute' => 'creado_por',
                'value' => $model->creadoPor->name . ' ' . $model->creadoPor->surname
            ],
            'creado_el',
            [
                'attribute' => 'actualizado_por',
                'value' => $model->actualizadoPor->name . ' ' . $model->actualizadoPor->surname
            ],
            'actualizado_el',
        ],
    ]) ?>

</div>
