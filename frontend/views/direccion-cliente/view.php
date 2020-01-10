<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\DireccionCliente */

$this->title = $model->detalle;
$this->params['breadcrumbs'][] = ['label' => 'Mis direcciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="direccion-cliente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'pais_id',
                'value' => $model->pais->nombre
            ],
            [
                'attribute' => 'departamento_estado_id',
                'value' => $model->departamentoEstado->nombre
            ],
            'ciudad',
            'detalle',
        ],
    ]) ?>

</div>
