<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RespuestaProducto */

$this->title = 'Create Respuesta Producto';
$this->params['breadcrumbs'][] = ['label' => 'Respuesta Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="respuesta-producto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
