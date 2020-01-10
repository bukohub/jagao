<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Carousel;

/* @var $this yii\web\View */
/* @var $model frontend\models\Producto */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="producto-view">

    <h1>
        <?= Html::encode($this->title) ?>
        <img width="5%" src="<?= Yii::$app->urlManager->createUrl( Yii::$app->params['urlImagenesProveedores'] . $imagenProveedor->nombre_archivo) ?>">
    </h1>

    <div class="row">
        <div class="col-sm-4">
            <?php
            $items = [];
            $items[] = '<img src="' . Yii::$app->urlManager->createUrl( Yii::$app->params['urlImagenesProductos'] . $imagenPrincipal->nombre_archivo) . '">';
            foreach ($imagenesSegundarias as $imagenSeg) {
                $items[] = '<img src="' . Yii::$app->urlManager->createUrl( Yii::$app->params['urlImagenesProductos'] . $imagenSeg->nombre_archivo) . '">';
            }
            echo Carousel::widget([
                'items' => $items,
                'options' => [
//            'width' => 15
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-8">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'nombre',
                    'descripcion:ntext',
                    'cantidad_stock',
                    [
                        'attribute' => 'precio_pesos',
                        'value' => function() use($model) {
                            return '$ ' . number_format($model->precio_pesos, 2, ',', '.');
                        }
                    ],
                
                    [
                        'attribute' => 'proveedor_id',
                        'value' => $model->proveedor->nombre .' <img width="8%" src="'.Yii::$app->urlManager->createUrl( Yii::$app->params['urlImagenesProveedores'] . $imagenProveedor->nombre_archivo).'">',
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'subcategorias',
                        'label'=>'Subcategorías',
                        'value' => function () use($subcategorias){
                            $cadena = '<ul>';
                            foreach ($subcategorias as $categoria){
                                $cadena .= '<li>'.$categoria->subcategoria->nombre.'</li>';
                            }
                            $cadena .= '<ul>';
                            return $cadena;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'tags',
                        'value' => function () use($tags){
                            $cadena = '';
                            foreach ($tags as $tag){
                                $cadena .= '<label class="label label-primary" style="font-size: 15px;">'.$tag.'</label> ';
                            }
                            return $cadena;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'estado_producto_id',
                        'value' => $model->estadoProducto->descripcion
                    ],
                    'calificacion_promedio',
                    [
                        'attribute' => 'creado_por',
                        'value' => $model->creadoPor->name . ' ' . $model->creadoPor->surname
                    ],
                    'creado_el',
                ],
            ])
            ?>
        </div>
    </div>



</div>
