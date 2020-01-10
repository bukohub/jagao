<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProductoCompras */

$this->title = 'Create Producto Compras';
$this->params['breadcrumbs'][] = ['label' => 'Producto Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-compras-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
