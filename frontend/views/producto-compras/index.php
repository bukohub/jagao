<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\models\EstadoCompra;
use frontend\models\Proveedor;
use jino5577\daterangepicker\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductoComprasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title =  'Compras de Productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php // echo $this->render('_search', ['model' => $searchModel]); 
   if(!(Yii::$app->user->can('r-administrador-jagao') or Yii::$app->user->can('r-proveedor'))) return;
?>
<div class="producto-compras-index">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?php
    
    $columnIna = [
        'header' => 'Pago Proveedor',
        'visible' => Yii::$app->user->can('r-administrador-jagao'),
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{no_pago}{pagado}',
        'buttons' => [
            'no_pago' => function ($url, $model) {
                if($model->pago_proveedor != '1'){
                    return Html::a('<span class="glyphicon glyphicon-refresh"></span>         ', ['pago-proveedor', 'id' => $model->id,'pay'=>2], [
                        'class' => '',
                        'title' => 'Pago pendiente',
                        'data' => [
                            'confirm' => '¿Está seguro que desea dejar pendiente el pago a este proveedor?',
                            'method' => 'post',
                        ],
                    ]);
                }
                
            },
            'pagado' => function ($url, $model) {
                if($model->pago_proveedor != '1'){
                return Html::a('<span class="glyphicon glyphicon-ok"></span>    ', ['pago-proveedor', 'id' => $model->id ,'pay'=>1], [
                    'class' => '',
                    'title' => 'Pagar a proveedor',
                    'data' => [
                        'confirm' => '¿Está seguro que desea pagarle a este proveedor?',
                        'method' => 'post',
                    ],
                ]);
                }
            },
            
        ]
    ];

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<label class="label label-primary"> Pendiente </label>'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             'codigo_factura',
             [
                'attribute' => 'numero_guia',
                'label' => 'Guía',
                'format' => 'raw',
                'value' => function ($data) {
                    if(!empty($data->nombre_archivo))
                    return Html::a($data->numero_guia,  Yii::$app->urlManager->createUrl(Yii::$app->params['urlImagenesSeguimiento'] . $data->nombre_archivo),['target'=>'_blank']);
                    else
                    return $data->numero_guia;
                },
            ],
            [
                'attribute' => 'producto_id',
                'value' => function ($data) {
                    return $data->producto->nombre;
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
                'filter' => ArrayHelper::map(EstadoCompra::find()->all(), 'id', 'descripcion'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            [
                'attribute' => 'proveedor',
                'value' => function ($data) {
                    return $data->producto->proveedor->nombre;
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Proveedor::find()->where(['estado_id'=>1])->all(), 'id', 'nombre'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            [
                'visible' => (Yii::$app->user->can('r-administrador-jagao') or Yii::$app->user->can('r-proveedor')),
                'attribute' => 'pago_proveedor',
                'value' => function ($data) {
                    switch ($data->pago_proveedor) {
                        
                        case 1:
                            return '<label class="label label-success"> Pago</label>';
                            break;
                        case 0:
                            return '<label class="label label-warning"> Sin pagar</label>';
                            break;
                        case 2:
                            return '<label class="label label-primary"> Pendiente de Pago</label>';
                            break;
                        default:
                           return '<label class="label label-warning"> Sin pagar </label>';
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(array(array('id'=>1,'descripcion'=>'Pago'),array('id'=>0,'descripcion'=>'Sin pagar'),array('id'=>2,'descripcion'=>'Pendiente de Pago')), 'id', 'descripcion'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            [
                'attribute' => 'user_id',
                'value' => function ($data) {
                    return $data->user->username;
                }
            ],
            [
                'attribute' => 'creado_el',
                'value' => function ($model) {
                        return date('Y-m-d G:i:s', strtotime($model->creado_el));
                },
                'headerOptions' => [
                    'class' => 'col-md-2'
                ],
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'creado_el_rango',
                    'pluginOptions' => [
                    'format' => 'd-m-Y',
                    'autoUpdateInput' => false
                ]
                ])
            ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Acciones',
                        'headerOptions' => ['style' => 'color:#337ab7'],
                        'template' => '{view}{update}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>     ', $url, [
                                    'title' => Yii::t('app', 'Ver'),
                                ]);
                            },
        
                            'update' => function ($url, $model) {
                                if (Yii::$app->user->can('r-proveedor') and !Yii::$app->user->can('r-administrador-jagao')) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>       ', $url, [
                                        'title' => Yii::t('app', 'Actualizar'),
                                    ]);
                                }
                            },
                        ]
                    ],
            $columnIna


        ],
    ]); ?>


</div>