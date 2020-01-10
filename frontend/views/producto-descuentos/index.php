<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductoDescuentosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Descuento de Productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-descuentos-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <p>
            <?php
                if(Yii::$app->user->can('r-proveedor') and !Yii::$app->user->can('r-administrador-jagao'))
                 echo Html::a('Crear un descuento', ['create'], ['class' => 'btn btn-success'])
            ?>
        </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'producto_id',
                  'value' => function($data){
                      return $data->producto->nombre;
                  }
              ],
            'descuento',
            [
                'attribute' => 'creado_por',
                  'value' => function($data){
                      return $data->creadoPor->username;
                  }
              ],
            'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
