<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\Categoria;

/* @var $this yii\web\View */
/* @var $model frontend\models\Subcategoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subcategoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>


    <div class="row">
        <div class="col-sm-12">
        <?= (!$update) ? $form->field($model, 'estado')->textInput(['value'=>'Activo','type'=>'hidden'])->label(false) :  $form->field($model, 'estado')->dropDownList([ 'Activo' => 'Activo', 'Devuelto' => 'Devuelto', 'Rechazo' => 'Rechazo', 'Por revisar' => 'Por revisar', ], ['prompt' => '']);?>

        </div>

        <div class="col-md-12">
        <i class="fa fa-bookmark" aria-hidden="true"></i> <label>Categorias</label>
            <?php
            $data = ArrayHelper::map(Categoria::find()->where(['estado' => 'Activo'])->all(), 'id', 'nombre');
            echo $form->field($model, 'categoria_id')->widget(Select2::classname(), [
                'data' => $data,
                'options' => ['placeholder' => 'Seleccione ...'],
                'pluginOptions' => [
                    'tokenSeparators' => [',', ' '],
                ],
            ])->label(false)
            ?>
        </div>
    </div>
   


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
