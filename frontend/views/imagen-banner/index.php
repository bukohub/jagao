<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ImagenBannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Creación de Banners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imagen-banner-index">

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

            'id',
            'descripcion_principal',
            'descripcion_secundaria',
         
            'nombre_archivo',
            //'ruta_archivo',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
