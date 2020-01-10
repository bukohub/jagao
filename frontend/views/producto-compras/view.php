<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProductoCompras */

$this->title = $model->codigo_factura;

$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="producto-compras-view">

    <h1>Factura: <?= Html::encode($this->title) ?></h1>


    <p>
        <?php
         if(Yii::$app->user->can('r-administrador-jagao') or Yii::$app->user->can('r-proveedor'))
            echo Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])         
        ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<label class="label label-primary"> Pendiente </label>'],
        'attributes' => [
            ['attribute' => 'proveedor',
            'value' => function ($data) {
                return $data->producto->proveedor->nombre;
            }
            ],
            [
                'attribute' => 'producto_id',
                'value' => $model->producto->nombre
            ],
            [
                'attribute' => 'producto_id_talla',
                'label'=>'Talla del Producto',
                'value' => 'Color: '. $model->productoTalla->codigo_color . ' - Talla: ' .$model->productoTalla->talla->descripcion
            ],
            'cantidad',
            ['attribute'=>'precio_costo', 'value'=>'$' . number_format($model->precio_costo, 2, ',', '.')],
            ['attribute'=>'costo_envio', 'value'=>'$' . number_format($model->costo_envio, 2, ',', '.')],
            ['attribute'=>'precio_total', 'value'=>'$' . number_format($model->precio_total, 2, ',', '.')],
            'nombre_transportadora',
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
                'attribute' => 'estado_id',
                'label'=>'Estado Compra',
                'format' => 'raw',
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
                }
            ],
            [
                'attribute' => 'user_id',
                'value' => $model->user->username
            ],
            'creado_el'

        ],
    ]) ?>
<br>

    <h3>Información de Envío</h3>
    <hr style="border-top: 1px solid #b3b3b3;">
    <?= DetailView::widget([
        'model' => $model,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<label class="label label-primary"> Pendiente </label>'],
        'attributes' => [
            [
                'attribute' => 'id_info_compra',
                'label' =>'Nombre',
                'value' => $model->informacionCompra->nombre
            ],
            [
                'attribute' => 'id_info_compra',
                'label' =>'Apellido',
                'value' => $model->informacionCompra->apellido
            ],
            [
                'attribute' => 'id_info_compra',
                'label' =>'Cédula',
                'value' => $model->informacionCompra->cedula
            ],
            [
                'attribute' => 'id_info_compra',
                'label' =>'Dirección',
                'value' => $model->informacionCompra->direccion
            ],
            [
                'attribute' => 'id_info_compra',
                'label' =>'País',
                'value' => $model->informacionCompra->pais->nombre
            ],
            [
                'attribute' => 'id_info_compra',
                'label' =>'Departamento',
                'value' => $model->informacionCompra->depto->nombre
            ],[
                'attribute' => 'id_info_compra',
                'label' =>'Ciudad',
                'value' => $model->informacionCompra->ciudad->nombre
            ],
            [
                'attribute' => 'id_info_compra',
                'label' =>'Teléfono',
                'value' => $model->informacionCompra->telefono
            ],
            [
                'attribute' => 'id_info_compra',
                'label' =>'Email',
                'value' => $model->informacionCompra->email
            ],
            [
                'attribute' => 'id_info_compra',
                'label' =>'Creado Por',
                'value' => $model->informacionCompra->creadoPor->username
            ],
            [
                'attribute' => 'id_info_compra',
                'label' =>'Creado El',
                'value' => $model->informacionCompra->creado_el
            ],
        ],
    ]) ?>

</div>