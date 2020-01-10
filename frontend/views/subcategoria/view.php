<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Subcategoria */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Subcategorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="subcategoria-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'descripcion:ntext',
            'estado',
            [
                'attribute' => 'categoria_id',
                'value' => $model->categoria->nombre
            ],
            [
                'attribute' => 'creado_por',
                'value' => $model->creadoPor->username
            ],
            'creado_el',
            [
                'attribute' => 'creado_por',
                'value' => $model->actualizadoPor->username
            ],
            'actualizado_el',
        ],
    ]) ?>

</div>
