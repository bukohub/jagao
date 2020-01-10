<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use frontend\models\Pais;
use frontend\models\EstadoDepartamento;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\DireccionCliente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="direccion-cliente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'pais_id')->dropDownList(ArrayHelper::map(Pais::find()->all(),'id','nombre'),  ['id'=>'pais-id','prompt'=>'Seleccione un País'])
    ?>

    <?=
    $form->field($model, 'departamento_estado_id')->widget(DepDrop::classname(), [
        'options'=>['id'=>'depto-id'],
        'data'=> [$model->departamento_estado_id => $model->departamento_estado_id],
        'pluginOptions'=>[
            'depends'=>['pais-id'],
            'initialize' => $model->isNewRecord ? false : true,
            'params'=> ['selected_id'], 
            'placeholder'=>'Seleccionar departamento...',
            'url'=>Url::to(['/direccion-cliente/departamentos'])
        ]
    ]);

    ?>
 <?=
    $form->field($model, 'ciudad')->widget(DepDrop::classname(), [
        'data'=> [$model->ciudad => $model->ciudad],
        'options'=>['id'=>'ciudad-id'],
        'pluginOptions'=>[
            'depends'=>['depto-id'],
            'placeholder'=>'Seleccionar ciudad...',
            'url'=>Url::to(['/direccion-cliente/ciudades'])
        ]
    ]);
    ?>


    <?= $form->field($model, 'detalle')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php
    ActiveForm::end();
    ?>

</div>
