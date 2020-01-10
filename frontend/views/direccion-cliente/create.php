<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\DireccionCliente */

$this->title = 'Nueva dirección';
$this->params['breadcrumbs'][] = ['label' => 'Mis direcciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="direccion-cliente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
