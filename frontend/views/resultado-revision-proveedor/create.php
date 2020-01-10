<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ResultadoRevisionProveedor */

$this->title = 'Create Resultado Revision Proveedor';
$this->params['breadcrumbs'][] = ['label' => 'Resultado Revision Proveedors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resultado-revision-proveedor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
