<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Ingreso';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div style="color:#999;margin:1em 0">
                Si olvidaste tu contraseña puedes <?= Html::a('reestrablecerla aquí.', ['site/request-password-reset']) ?>
                <br>
                ¿Necesitas un nuevo email de verificación? <?= Html::a('Reenvíalo', ['site/resend-verification-email']) ?>
            </div>

            <div class="form-group" style="text-align:center;">
                <?= Html::submitButton('Ingresar', ['class' => 'le-button', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
