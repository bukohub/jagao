<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProductoCalificacion */

$this->title = 'Calificar producto';
$this->params['breadcrumbs'][] = ['label' => 'Producto Calificacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-calificacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'products'=>$products
    ]) ?>

</div>
