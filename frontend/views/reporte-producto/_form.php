<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use frontend\models\TipoReporteProducto;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReporteProducto */
/* @var $form yii\widgets\ActiveForm */
?>

<div >

    <?php
    $data = ArrayHelper::map(TipoReporteProducto::find()->all(), 'id', 'descripcion');
    $form = ActiveForm::begin(
                    [
                        'type' => ActiveForm::TYPE_VERTICAL,
                        'action' => Yii::$app->urlManager->createUrl([
                            'reporte-producto/create']),
                        'method' => 'POST',
                        'id'=>'popup_reporte'
                    ]
    );
    ?>

    <?= $form->field($model, 'tipo_reporte_producto_id')->dropDownList($data, ['prompt' => '','required' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6,'required' => true]) ?>
    <?=
    $form->field($model, 'producto_id')->textInput(
            [
                'type' => 'hidden',
                'value' => $idProducto
            ]
    )->label(false)
    ?>

    <div class="form-group text-right">
        <?= Html::submitButton('Enviar', ['class' => 'le-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
