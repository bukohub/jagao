<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AcercaJagao */

$this->title = 'Crear';
$this->params['breadcrumbs'][] = ['label' => 'Acerca Jagaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acerca-jagao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
