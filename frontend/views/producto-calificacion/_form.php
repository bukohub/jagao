<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Producto;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use kartik\widgets\StarRating;


/* @var $this yii\web\View */
/* @var $model frontend\models\ProductoCalificacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="producto-calificacion-form">
    <?php
    if (!empty($products)) :
        ?>
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-sm-6">
                <i class="fa fa-shopping-basket" aria-hidden="true"></i> <label>Producto</label>
                <?= $form->field($model, 'producto_id')->dropDownList([$products->id => $products->nombre], ['disabled' => 'disabled']); ?>
            </div>
            <div class="col-sm-6">
                <?=
                        $form->field($model, 'calificacion')->widget(StarRating::classname(), [
                            'pluginOptions' => [
                                'theme' => 'krajee-uni',
                                'filledStar' => '&#x2605;',
                                'emptyStar' => '&#x2606;',
                                'showClear' => false,
                            ]
                        ]);
                    ?>
            </div>
            <div class="col-sm-12">
                <i class="fa fa-align-justify" aria-hidden="true"></i> <label>Escribe un comentario sobre el producto</label>
                <?= $form->field($model, 'descripcion')->textarea(['rows' => 5])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?php else : ?>
        <h4>¡Ups! No has realizado alguna compra aún.</h4>
    <?php endif; ?>

</div>