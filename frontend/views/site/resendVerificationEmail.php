<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reenviar email de verificación';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-resend-verification-email">
<div class="row">
        <div class="col-sm-6 col-sm-offset-3">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor revisa tu correo electrónico. Un email de verificación será enviado. </p>

    <div class="row">
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form']); ?>

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

