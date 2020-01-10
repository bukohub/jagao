<?php

use common\models\User;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TipoReporteProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipo Reporte Productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-reporte-producto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'descripcion:ntext',
            [
                'attribute' => 'creado_por',
                'value' => function ($data) {
                    return $data->creadoPor->username;
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map( User::find()->all(), 'id', 'username'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ], 
            'creado_el',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
