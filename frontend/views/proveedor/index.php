<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\models\Estado;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProveedorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proveedores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proveedor-index">

    <?php
    if (Yii::$app->user->can('r-proveedor') || Yii::$app->user->can('r-administrador-jagao')) {
        ?>
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?php
                if (!Yii::$app->user->can('r-administrador-jagao'))
                    echo Html::a('Crear proveedor', ['create'], ['class' => 'btn btn-success'])
                    ?>
        </p>

        <?php // echo $this->render('_search', ['model' => $searchModel]);  
            ?>

        <?php
            $columnaAcciones = [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}{update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => 'Ver',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        if ($model->estado_id == 3 || Yii::$app->user->can('r-proveedor')) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => 'Actualizar',
                            ]);
                        }
                    },
                ]
            ];

            $columnIna = [
                'header' => 'Cambiar <br> Estado',
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{inactivar}',
                'buttons' => [
                    'inactivar' => function ($url, $model) {
                        switch ($model->estado->id) {
                            case '1':
                                return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', ['inactivar'], [
                                    'class' => 'inactivar',
                                    'title' => 'Inactivar',
                                    'data-trunc' => $model->id
                                ]);
                                break;
                            case '2':

                                return Html::a('<span class="glyphicon glyphicon-ok "></span>', ['activar', 'id' => $model->id], [
                                    'class' => 'activar',
                                    'title' => 'Activar',
                                    'data' => [
                                        'confirm' => '¿Está seguro que desea activar este proveedor? ',
                                        'method' => 'post',
                                    ],
                                ]);
                                break;
                        }
                    },
                ]
            ];
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'nombre',
                    'identificacion_nit',
                    [
                        'attribute' => 'usuario_id',
                        'label'=>'Usuario',
                        'value' => function ($data) {
                            return $data->creadoPor->username;
                        }
                    ],
                    [
                        'attribute' => 'estado_id',
                        'value' => function ($data) {
                            switch ($data->estado_id) {
                                case 1:
                                    return '<label class="label label-success">' . $data->estado->descripcion . '</label>';
                                    break;
                                case 2:
                                    return '<label class="label label-danger">' . $data->estado->descripcion . '</label>';
                                    break;
                                case 3:
                                    return '<label class="label label-warning">' . $data->estado->descripcion . '</label>';
                                    break;
                                case 4:
                                    return '<label class="label label-primary">' . $data->estado->descripcion . '</label>';
                                    break;
                            }
                        },
                        'format' => 'raw',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(Estado::find()->all(), 'id', 'descripcion'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                    ],

                    $columnaAcciones,
                    $columnIna,
                ],
            ]);
            ?>
            <?php
            } else {
                ?>
                <div class="container">
                    <div class="jumbotron">
                        <h1>¿Quieres ofertar tus productos en JAGAO.CO?</h1>
                        <p>Para iniciar es necesario que diligencies el formulario que hemos diseñado. Luego, revisaremos tu solicitud y se te confirmará por medio de correo electrónico el resultado de tu solicitud. Adelante, inténtalo.</p>
                        <div class="text-center">
                            <?= Html::a('Diligencía el formulario aquí <i class="fa fa-truck" aria-hidden="true"></i>', ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

            <div class="modal bootstrap-dialog type-warning fade size-normal in" id="ina_pro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <div class="bootstrap-dialog-title" id="w3_title">Inactivación de Proveedor</div>
                        </div>
                        <div class="modal-body">
                             <div class="bootstrap-dialog-body"><div class="bootstrap-dialog-message">
                                 ¿Está seguro que desea inactivar este proveedor? De ser así, escriba una observación para ser enviada al proveedor.
<br>
                                 <br>
                                 <label for="">Observación</label>
                                 <input name="id_prov_ina" type="hidden" >
                                 <textarea name="observacion_ina" rows="5" type="text" class="form-control" placeholder="Escriba una observación de inactivación de proveedor..."></textarea>
<br>

                             </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                             <button class="btn btn-default" id="close_ina" data-dismiss="modal"><span class="glyphicon glyphicon-ban-circle"></span>  Cancelar</button>
                            <button class="btn btn-warning" id="aceptar_ina"><span class="glyphicon glyphicon-ok"></span> De acuerdo</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            var url_ = '<?php echo Yii::$app->request->baseUrl ?>';
            </script>
            <?php
            $this->registerJsFile(
                '@web/js/proveedor.js',
                ['depends' => [\yii\web\JqueryAsset::className()]]
            );
            ?>
</div>