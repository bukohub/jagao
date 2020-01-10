<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Proveedor */

$this->title = 'Actualizando proveedor: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Proveedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="proveedor-update">

    <h1>
        <?= Html::encode($this->title) ?>
        <img width="5%" src="<?= Yii::$app->urlManager->createUrl( Yii::$app->params['urlImagenesProveedores'] . $model->imagenProveedors->nombre_archivo) ?>">

    </h1>


    <?=
    $this->render('_form', [
        'model' => $model,
        'imagen' => $imagen
    ])
    ?>

</div>
