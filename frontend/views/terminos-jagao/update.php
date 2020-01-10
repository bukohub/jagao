<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TerminosJagao */

$this->title = 'Actualizar Terminos Jagao: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Terminos Jagao', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="terminos-jagao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
