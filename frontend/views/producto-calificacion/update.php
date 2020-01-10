<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProductoCalificacion */

$this->title = 'Actualizar Calificación: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Producto Calificacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="producto-calificacion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'products'=>$products
    ]) ?>

</div>
