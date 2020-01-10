<?php

use frontend\models\Bancos;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Estado;
use frontend\models\TerminosJagao;
use frontend\models\TipoDocumento;
use frontend\models\TipoPersona;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Proveedor */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    div#modal,
    #contrato {
        z-index: 9999 !important;
    }

    hr {
        border-top: 1px solid rgba(0, 0, 0, .1);
        margin: 1px 0 20px 0;
    }

    .file-input .input-group-btn {
        width: 124px !important;
    }
</style>
<div class="proveedor-form">

    <?php $form = ActiveForm::begin(); ?><br>
    <h4>Información de la Compañía</h4>
    <hr />
    <div class="row">

        <div class="col-sm-4">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'identificacion_nit')->textInput(['maxlength' => true]) ?>
            <p class="help-block">La identifcación ingresada debe ser real para permitirle a este
                proveedor publicar productos.</p>
        </div>
        <div class="col-sm-4">
            <label for="">RUT</label>
            <?=
                $form->field($model, 'runt')->widget(FileInput::classname(), [
                    'options' => [
                        'required' => $model->isNewRecord ? true : false
                    ],
                    'pluginOptions' => [
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-danger',
                    ]
                ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'nombre_propietario')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'tipo_documento_propietario')->dropdownList(
                ArrayHelper::map(TipoDocumento::find()->all(), 'id', 'nombre'),
                ['prompt' => 'Seleccione un tipo de documento']
            ); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'no_doc_propietario')->textInput(['maxlength' => true, 'type' => 'number']) ?>
        </div>
        <div class="col-sm-12">
            <label for="">Documento de Identificación (frontal y posterior)</label>
            <?=
                $form->field($model, 'documento')->widget(FileInput::classname(), [
                    'options' => [
                        'required' => $model->isNewRecord ? true : false
                    ],
                    'pluginOptions' => [
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-danger',
                    ]
                ])->label(false);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?=
                $form->field($model, 'imagen')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*',
                        'required' => $model->isNewRecord ? true : false
                    ],
                    'pluginOptions' => [
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => false,
                        'allowedFileExtensions' => ['png'],
                        'browseClass' => 'btn btn-danger',
                    ]
                ]);
            ?>
            <p class="help-block">Debe ser una imagen en formato PNG con fondo transparente para poder ser usada en la vista de la información de este proveedor.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label for="">Descripción de la Actividad Comercial</label>
            <?= $form->field($model, 'descripcion')->textarea(['rows' => 5])->label(false) ?>
            <p class="help-block">Por favor ingrese una descripción detallada de su empresa</p>
        </div>
    </div>
    <br>
    <h4>Redes Sociales</h4>
    <hr />
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'facebook')->textInput(['placeholder' => 'Ingrese la página de Facebook de su empresa...', 'maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'instagram')->textInput(['placeholder' => 'Ingrese la página de Instagram de su empresa...', 'maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'twitter')->textInput(['placeholder' => 'Ingrese la página de Twitter de su empresa...', 'maxlength' => true]) ?>
        </div>
    </div>
    <br>
    <h4>Información Bancaria (Debe ser a nombre de quien registra en el RUT)</h4>
    <hr />

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'nombre_destinatario')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'tipo_documento')->dropdownList(
                ArrayHelper::map(TipoDocumento::find()->all(), 'id', 'nombre'),
                ['prompt' => 'Seleccione un tipo de documento']
            ); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'no_documento')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="row">


        <div class="col-sm-4">
            <?= $form->field($model, 'banco')->dropdownList(
                ArrayHelper::map(Bancos::find()->all(), 'id', 'nombre'),
                ['prompt' => 'Seleccione un banco']
            ); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'tipo_cuenta')->dropdownList(
                ArrayHelper::map(TipoPersona::find()->all(), 'id', 'nombre'),
                ['prompt' => 'Seleccione un tipo de cuenta']
            ); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'numero_cuenta')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12">
            <label for="">Certificado Bancario</label>
            <?=
                $form->field($model, 'certificado_bk')->widget(FileInput::classname(), [
                    'options' => [
                        'required' => $model->isNewRecord ? true : false
                    ],
                    'pluginOptions' => [
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-danger',
                    ]
                ])->label(false);
            ?>
        </div>

    </div>
  

    <div class="row">
        <div class="col-sm-12 test">
            <label for=""> <?php echo Html::a('Revisa los términos del contrato para proveedores',   Url::to(['terminos-jagao/terminos-contrato']) ,['target'=>'_blank']); ?></label>
            <?= $form->field($model, 'contrato')->checkboxList([
                1 => 'Acepto',
            ])->label(false);
            ?>
        </div>

    </div>

    <div class="text-right">
        <div class="form-group">
            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Guardar', ['class' => 'btn btn-success btn-lg']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>