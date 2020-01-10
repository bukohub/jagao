<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Producto */

$this->title = 'Actualizando el producto: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizando';
?>
<div class="producto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
        'imagenPrincipal' => $imagenPrincipal,
        'imagenesSegundarias' => $imagenesSegundarias,
    ])
    ?>

</div>
