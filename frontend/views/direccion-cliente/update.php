<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\DireccionCliente */

$this->title = 'Actualizar dirección: ' . $model->detalle;
$this->params['breadcrumbs'][] = ['label' => 'Mis direcciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->detalle, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actalizar dirección';
?>
<div class="direccion-cliente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
