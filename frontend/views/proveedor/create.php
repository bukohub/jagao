<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Proveedor */

$this->title = 'Crear proveedor';
if(!empty($primerVez) && $primerVez){
    $this->params['breadcrumbs'][] = ['label' => 'Primer vez', 'url' => ['primera-vez']];
}else{
    $this->params['breadcrumbs'][] = ['label' => 'Proveedores', 'url' => ['index']];
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proveedor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
