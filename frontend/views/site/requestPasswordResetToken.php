<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Restablecer contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Ingresa tu correo electrónico. Un link será enviado a la dirección proporcionada.</p>

            <div class="row">
                <div class="col-lg-10">
                    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Enviar', ['class' => 'le-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
