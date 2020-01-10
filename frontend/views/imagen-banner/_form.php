<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ImagenBanner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="imagen-banner-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'descripcion_principal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion_secundaria')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-sm-8">
            <p>
                <i class="fa fa-camera" aria-hidden="true"></i> <label>Subir Imagen</label>
                <?=
               $form->field($model, 'banners')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                    'required' => $model->isNewRecord ? true : false
                ],
                'pluginOptions' => [
                    'showCaption' => true,
                    'showRemove' => true,
                    'showUpload' => false,
                    'browseClass' => 'btn btn-danger',
                ]
                 ])->label(false);
                ?>
            </p>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
