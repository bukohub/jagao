<?php

use phpnt\summernote\SummernoteWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TerminosJagao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="terminos-jagao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'texto_terminos_contrato')->widget(SummernoteWidget::class,[
                'options' => [
                    'id' => 'texto_terminos_contrato'
                ],
                'i18n' => true,             
                'codemirror' => true,       
                'emoji' => true,             
                'widgetOptions' => [
                    'placeholder' => Yii::t('app', 'Escriba los términos del contrato para la creación de Proveedores.'),
                    'height' => 200,
                    'tabsize' => 2,
                    'minHeight' => 200,
                    'maxHeight' => 200,
                    'focus' => true,
                    'toolbar' => [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['paragraph','style']],
                        ['height', ['height']],
                        ['misc', ['codeview']],
                    ],
                ],
            ])->label("Términos del Contrato (Proveedor)"); ?>

    <?= $form->field($model, 'texto_politica_datos')->widget(SummernoteWidget::class,[
                'options' => [
                    'id' => 'texto_politica_datos'
                ],
                'i18n' => true,             
                'codemirror' => true,       
                'emoji' => true,             
                'widgetOptions' => [
                    'placeholder' => Yii::t('app', 'Escriba los términos, condiciones y política de datos para el registro de usuarios...'),
                    'height' => 200,
                    'tabsize' => 2,
                    'minHeight' => 200,
                    'maxHeight' => 200,
                    'focus' => true,
                    'toolbar' => [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['paragraph','style']],
                        ['height', ['height']],
                        ['misc', ['codeview']],
                    ],
                ],
            ])->label("Términos y Condiciones y Política de Datos (Registro de Usuario)"); ?>

 
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
