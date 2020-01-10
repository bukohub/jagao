<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ResultadoRevisionProveedor */

$this->title = 'Update Resultado Revision Proveedor: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Resultado Revision Proveedors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="resultado-revision-proveedor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
