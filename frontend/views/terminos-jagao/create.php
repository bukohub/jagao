<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TerminosJagao */

$this->title = 'Crear Terminos Jagao';
$this->params['breadcrumbs'][] = ['label' => 'Terminos Jagaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="terminos-jagao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
