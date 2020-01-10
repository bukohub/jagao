<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ResultadoRevisionCategoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resultado-revision-categoria-form">

    <?php
    $form = ActiveForm::begin(
                    [
                        'action' => Yii::$app->urlManager->createUrl([
                            'resultado-revision-categoria/create',]),
                        'method' => 'POST',
                    ]
    );
    ?>

    <?= $form->field($model, 'resultado')->dropDownList(['Aprobado' => 'Aprobado', 'Devuelto' => 'Devuelto', 'Rechazado' => 'Rechazado',], ['prompt' => '']) ?>

    <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'categoria_id')->textInput(['type' => 'hidden', 'value' => $idCategoria])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
