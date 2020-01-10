<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AcercaJagaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Acerca de Jagao';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acerca-jagao-index">

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

            'id',[
                'attribute' => 'descripcion',
                'format' => 'text',
                'label' => 'Descripción',
                'contentOptions' => ['style' => 'width:800px; white-space: normal;'],
            ],
            'telefono',
            'correo',
            'direccion',
            //'facebook',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
