<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SubcategoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subcategorias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcategoria-index">

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
            'nombre',
            'descripcion:ntext',            
            [
                'attribute' => 'categoria_id',
                  'value' => function($data){
                      return $data->categoria->nombre;
                  }
              ],
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
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
