<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ResultadoRevisionProveedor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resultado-revision-proveedor-form">

    <?php
    $form = ActiveForm::begin([
                'action' => Yii::$app->urlManager->createUrl([
                    'resultado-revision-proveedor/create',]),
                'method' => 'POST',
    ]);
    ?>

    <?= $form->field($model, 'resultado')->dropDownList(['Aprobado' => 'Aprobado', 'Rechazado' => 'Rechazado',], ['prompt' => '']) ?>

    <?= $form->field($model, 'proveedor_id')->textInput(['type' => 'hidden', 'value' => $idProveedor])->label(false) ?>

    <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

    <div class="text-right">
        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
