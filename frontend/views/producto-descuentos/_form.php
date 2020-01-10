<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Producto;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProductoDescuentos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="producto-descuentos-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
        <i class="fa fa-shopping-basket" aria-hidden="true"></i> <label>Producto</label>
            <?php
           $data = ArrayHelper::map(Producto::find()->where(["creado_por"=>Yii::$app->user->id])->all(), 'id', 'nombre');
            echo $form->field($model, 'producto_id')->widget(Select2::classname(), [
                'data' => $data,
                'options' => ['placeholder' => 'Seleccione ...'],
                'pluginOptions' => [

                    'tokenSeparators' => [',', ' ']
                ],
            ])->label(false)
            ?>
        
        </div>
        <div class="col-sm-6">
        <i class="fa fa-money" aria-hidden="true"></i> <label>Descuento</label>
            <?=
            $form->field($model, 'descuento')->widget(NumberControl::classname(), [
                'maskedInputOptions' => [
                    'prefix' => '% ',
                    'digits' => 0,
                    'max' => 100,
                    'groupSeparator' => '.',
                    'allowMinus' => false,
                    'radixPoint' => ',',
                    'maxlength' => 13
                ],
                'options' => [
                    'id' => 'precio-pesos'
                ]
            ])->label(false)
            ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>