<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ImagenBanner */

$this->title = 'Crear Banner';
$this->params['breadcrumbs'][] = ['label' => 'Imagen Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imagen-banner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
