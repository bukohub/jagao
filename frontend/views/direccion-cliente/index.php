<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DireccionClienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis direcciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="direccion-cliente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Nueva dirección', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'detalle',
            [
                'attribute' => 'pais_id',
                'value' => function($data){
                    return $data->pais->nombre;
                }
            ],
            [
                'attribute' => 'departamento_estado_id',
                'value' => function ($data){
                    return $data->departamentoEstado->nombre;
                }
            ],
            [
                'attribute' => 'ciudad',
                'value' => function ($data){
                    return $data->municipio->nombre;
                }
            ],
            
            //'usuario_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
