<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ResultadoRevisionCategoria */

$this->title = 'Update Resultado Revision Categoria: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Resultado Revision Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="resultado-revision-categoria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
