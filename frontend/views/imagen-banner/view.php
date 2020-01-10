<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ImagenBanner */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Imagen Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="imagen-banner-view">

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
            'descripcion_principal',
            'descripcion_secundaria',
            'nombre_archivo_original',
            'nombre_archivo',
            'ruta_archivo',
            'creado_por',
            'creado_el',
            'actualizado_por',
            'actualizado_el',
        ],
    ]) ?>

</div>
