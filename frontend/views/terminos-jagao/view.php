<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\TerminosJagao */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Terminos Jagao', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="terminos-jagao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Desea eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'texto_terminos_contrato',
                'label' => 'Términos del contrato',
                'format' => 'raw',
                'value' => function ($data) {
                    if(!empty($data->texto_terminos_contrato))
                    return Html::a('Ver términos del contrato',   Url::to(['terminos-jagao/terminos-contrato']) ,['target'=>'_blank']);
                },
            ],
            [
                'attribute' => 'texto_politica_datos',
                'label' => 'Términos y Condiciones y Política de Datos',
                'format' => 'raw',
                'value' => function ($data) {
                    if(!empty($data->texto_politica_datos))
                    return Html::a('Ver términos y Condiciones y Política de Datos',  Url::to(['terminos-jagao/terminos-usuario']) ,['target'=>'_blank']);
                },
            ],
            'creado_por',
            'creado_el',
            'actualizado_por',
            'actualizado_el',
        ],
    ]) ?>

</div>
