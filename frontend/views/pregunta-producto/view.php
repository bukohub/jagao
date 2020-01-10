<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\RespuestaProducto;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model frontend\models\PreguntaProducto */

$this->title = 'Pregunta sobre el producto: ' . $model->producto->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Preguntas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pregunta-producto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'producto_id',
                'label' => 'Producto',
                'value' => $model->producto->nombre
            ],
            'descripcion:ntext',
            [
                'attribute' => 'estado_pregunta_id',
                'label' => 'Estado de la pregunta',
                'value' => $model->estadoPregunta->descripcion
            ],
            [
                'attribute' => 'creado_por',
                'label' => 'Usuario que pregunta',
                'value' => $model->creadoPor->username
            ],
            [
                'attribute' => 'creado_el',
                'label' => 'Fecha de pregunta',
            ]
        ],
    ])
    ?>
    
    <div>
        <?php
        if ($model->estado_pregunta_id == 1 && $model->producto->creadoPor->id == Yii::$app->user->id) {
            Modal::begin([
                'header' => '<h2>Respuesta</h2>',
                'headerOptions' => [
                    'style' => 'background-color:#dd4b39;color:#fff;'
                ],
                'toggleButton' => [
                    'label' => '<i class="fa fa-check-circle-o" aria-hidden="true"></i>',
                    'class' => 'btn btn-danger btn-lg pull-right'
                ],
            ]);
            echo $this->render('//respuesta-producto/_form', ['model' => new RespuestaProducto(), 'idPregunta' => $model->id]);
            Modal::end();
        }
        ?>
    </div>

</div>
