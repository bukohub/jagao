<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ResultadoRevisionProveedorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resultado Revision Proveedors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resultado-revision-proveedor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Resultado Revision Proveedor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'resultado',
            'proveedor_id',
            'observacion:ntext',
            'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
