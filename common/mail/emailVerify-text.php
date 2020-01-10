<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
Hola <?= $user->username ?>,

Por favor da clic en el siguiente enlace para verificar tu cuenta.

<?= $verifyLink ?>
