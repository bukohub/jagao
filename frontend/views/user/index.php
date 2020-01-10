<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'surname',
            'username',
            'email:email',
            //'estado',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            //'verification_token',
            //'creado_por',
            //'created_at',
            //'actualizado_por',
            //'updated_at',

            [
                'header' => 'Cambiar <br> Estado',
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{inactivar}',
                'buttons' => [
                    'inactivar' => function ($url, $model) {
                        switch ($model->estado) {
                            case '1':
                                return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', ['inactivar','id' => $model->id], [
                                    'class' => 'inactivar',
                                    'title' => 'Inactivar',
                                    'data-trunc' => $model->id,
                                    'data' => [
                                        'confirm' => '¿Está seguro que desea inactivar este cliente? ',
                                        'method' => 'post',
                                    ],
                                ]);
                                break;
                            case '0':

                                return Html::a('<span class="glyphicon glyphicon-ok "></span>', ['activar', 'id' => $model->id], [
                                    'class' => 'activar',
                                    'title' => 'Activar',
                                    'data' => [
                                        'confirm' => '¿Está seguro que desea activar este cliente? ',
                                        'method' => 'post',
                                    ],
                                ]);
                                break;
                        }
                    },
                ]
            ],
        ],
    ]); ?>


</div>
