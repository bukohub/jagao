<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AcercaJagaoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acerca-jagao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'telefono') ?>

    <?= $form->field($model, 'correo') ?>

    <?= $form->field($model, 'direccion') ?>

    <?php // echo $form->field($model, 'facebook') ?>

    <?php // echo $form->field($model, 'creado_por') ?>

    <?php // echo $form->field($model, 'creado_el') ?>

    <?php // echo $form->field($model, 'actualizado_por') ?>

    <?php // echo $form->field($model, 'actualizado_el') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
