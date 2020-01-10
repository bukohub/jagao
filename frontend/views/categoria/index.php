<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CategoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categorias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear categoría', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $columnaAcciones = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view}{update}{delete}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => 'Ver',
                ]);
            },
            'update' => function ($url, $model) {
                if (Yii::$app->user->can('r-administrador-jagao') || ($model->estado == 'Devuelto' && $model->creado_por == Yii::$app->user->id)) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => 'Actualizar',
                    ]);
                }
            },
            'delete' => function ($url, $model) {
                if(Yii::$app->user->can('r-administrador-jagao') ){
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title'        => 'Eliminar',
                        'data-confirm' => Yii::t('yii', '¿Está seguro que desea eliminar esta categoría?'),
                        'data-method'  => 'post',
                    ]);
             
                }
                
            }
        ]
    ];

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            [
                'attribute' => 'estado',
                'value' => function ($model) {
                    switch ($model->estado) {
                        case 'Devuelto':
                            return '<label class="label label-warning">' . $model->estado . '</label>';
                            break;
                        case 'Activo':
                            return '<label class="label label-success">' . $model->estado . '</label>';
                            break;
                        case 'Rechazo':
                            return '<label class="label label-danger">' . $model->estado . '</label>';
                            break;
                        case 'Por revisar':
                            return '<label class="label label-primary">' . $model->estado . '</label>';
                            break;
                    }
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'creado_por',
                'value' => function ($data){
                    return $data->creadoPor->username;
                }
            ],
            $columnaAcciones,
        ],
    ]);
    ?>


</div>
