<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Producto */

$this->title = 'Crear producto';
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-create">

    <h1>
        <?= Html::encode($this->title) ?>
        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
    </h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
