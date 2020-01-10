<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProductoCompras */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="producto-compras-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'numero_guia')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'nombre_transportadora')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12">
            <i class="fa fa-camera" aria-hidden="true"></i> <label>Subir la imagen de la guía de envío</label>
            <?=
                $form->field($model, 'seguimiento')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*',
                        'required' => true
                    ],
                    'pluginOptions' => [
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-danger',
                    ]
                ])->label(false);
            ?>
            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>