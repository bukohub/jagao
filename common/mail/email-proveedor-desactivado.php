<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="verify-email">
    <p>Hola <?= Html::encode($user->username) ?>,</p>

    <p><?= $message ?></p>

</div>
