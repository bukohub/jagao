<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use frontend\models\TerminosJagao;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Registro';
?>
<div class="site-signup container">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor llena los siguientes campos para realizar el registro:</p>

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                
                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'surname')->textInput() ?>
                <?= $form->field($model, 'username')->textInput(['placeholder' => 'usuario.username']) ?>
                <p class="help-block">Ejemplos: jhon_doe, mark_01...</p>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <h6>Al registrarte en JAGAO.CO aceptas nuestros <?php echo Html::a('términos y condiciones y política de datos',  Url::to(['terminos-jagao/terminos-usuario']) ,['target'=>'_blank']); ?>.</h6><br>
                
                <div class="form-group" style="text-align:center;">
                    <?= Html::submitButton('Registrarme', ['class' => 'le-button', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
