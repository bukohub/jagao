<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Hola <?= Html::encode($user->username) ?>,</p>

    <p>Por favor da clic en el siguiente enlace para verificar tu cuenta.</p>

    <p> <?= Html::a("Verifica tu cuenta aquí", $verifyLink) ?></p>
</div>
