<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ResultadoRevisionCategoria */

$this->title = 'Create Resultado Revision Categoria';
$this->params['breadcrumbs'][] = ['label' => 'Resultado Revision Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resultado-revision-categoria-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
