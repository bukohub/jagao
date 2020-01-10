<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Categoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= (!$update) ? $form->field($model, 'estado')->textInput(['value'=>'Activo','type'=>'hidden'])->label(false) :  $form->field($model, 'estado')->dropDownList([ 'Activo' => 'Activo', 'Devuelto' => 'Devuelto', 'Rechazo' => 'Rechazo', 'Por revisar' => 'Por revisar', ], ['prompt' => '']);?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
