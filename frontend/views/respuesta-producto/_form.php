<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RespuestaProducto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="respuesta-producto-form">

    <?php
    $form = ActiveForm::begin([
                'action' => Yii::$app->urlManager->createUrl([
                    'respuesta-producto/create','idPregunta' => $idPregunta]),
                'method' => 'POST',
    ]);
    ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <div class="form-group text-right">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
