<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\ResultadoRevisionCategoria;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model frontend\models\Categoria */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="categoria-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
            'descripcion:ntext',
            [
                'attribute' => 'estado',
                'value' => function () use ($model) {
                    switch ($model->estado) {
                        case 'Activo':
                            return '<label class="label label-success">' . $model->estado . '</label>';
                            break;
                        case 'Devuelto':
                            return '<label class="label label-warning">' . $model->estado . '</label>';
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
                'value' => $model->creadoPor->username
            ],
            'creado_el',
        ],
    ])
    ?>

    <div>
        <?php
        if ($model->estado == 'Por revisar' && Yii::$app->user->can('r-administrador-jagao')) {
            Modal::begin([
                'header' => '<h2>Resultado revisión</h2>',
                'headerOptions' => [
                    'style' => 'background-color:#dd4b39;color:#fff;'
                ],
                'toggleButton' => [
                    'label' => '<i class="fa fa-check-circle-o" aria-hidden="true"></i>',
                    'class' => 'btn btn-danger btn-lg pull-right'
                ],
            ]);
            echo $this->render('//resultado-revision-categoria/_form', ['model' => new ResultadoRevisionCategoria(), 'idCategoria' => $model->id]);
            Modal::end();
        }
        ?>
    </div>

</div>
