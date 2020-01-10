<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<br>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <img class="img-responsive" src="<?php echo Yii::$app->request->baseUrl; ?>/imagenes/proveedores/<?= $proveedor->imagenProveedors->nombre_archivo ?>">
        </div>
        <div class="col-sm-6">
            <p>
                <?= $proveedor->descripcion ?>
            </p>
        </div>
    </div>
    <div class="row">
        <?php foreach ($productos as $producto): ?>
            <div style="border: 1px solid #E9E9E9; margin: 0.12px;" class="col-12 col-sm-3 col-md-3 single_gallery_item women wow fadeInUpBig" data-wow-delay="0.2s">
                <!-- Product Image -->
                <div class="product-img" style="width: auto; min-height: 350px;">
                    <img class="img-responsive" src="<?php echo Yii::$app->request->baseUrl; ?>/imagenes/productos/<?= $producto->imagenPrincipalProductos->nombre_archivo ?>" alt="">
                    <div class="product-quicview">
                        <a href="#" data-toggle="modal" data-target="#quickview<?= $producto->id ?>"><i class="ti-plus"></i></a>
                    </div>
                </div>
                <!-- Product Description -->
                <div class="product-description">
                    <h4 class="product-price">COP : <?= '$ ' . number_format($producto->precio_pesos, 2, ',', '.') ?></h4>
                    <p><?= $producto->nombre ?></p>
                    <p style="color:#ff9800;">
                        <?php for ($i = 1; $i <= $producto->calificacion_promedio; $i++): ?>
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                        <?php endfor; ?>
                    </p>
                    <p> <i class="fa fa-truck" aria-hidden="true"></i> Proveedor <a href="<?= Url::to(['proveedor/listado-productos-proveedor', 'idProveedor' => $producto->proveedor_id]) ?>"><?= $producto->proveedor->nombre ?></a></p>

                    <!-- Add to Cart -->
                    <a href="../index.php/producto/detalle-producto?idProducto=<?= $producto->id ?>" class="add-to-cart-btn pull-right">DETALLE <i class="fa fa-eye" aria-hidden="true"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <br>
    <div class="row">
        <div class="center-block shop_pagination_area wow fadeInUp" data-wow-delay="1.1s">
            <nav aria-label="Page navigation">
                <?php
                echo LinkPager::widget([
                    'pagination' => $pagination,
                    'options' => [
                        'class' => 'pagination pagination-sm'
                    ],
                    'linkOptions' => [
                        'class' => 'page-link'
                    ],
                    'linkContainerOptions' => [
                        'class' => 'page-item'
                    ]
                ]);
                ?>
            </nav>
        </div>
    </div>
</div>
<br>