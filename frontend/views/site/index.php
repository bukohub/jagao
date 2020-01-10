<?php

use frontend\models\ImagenBanner;
use yii\helpers\Html;
use yii\helpers\Url;
?>


<div id="top-banner-and-menu" class="homepage2">
    <div class="container">
        <div class="col-xs-12">
            <!-- ========================================== SECTION – HERO ========================================= -->
            <div id="hero">
                <div id="owl-main" class="owl-carousel height-lg owl-inner-nav owl-ui-lg">
                    <?php foreach (ImagenBanner::find()->all() as $imagen_banner) : ?>
                        <div class="item" style="background-image: url(<?php echo Yii::$app->request->baseUrl; ?>/imagenes/productos/<?= $imagen_banner->nombre_archivo ?>);">
                            <div class="container-fluid">
                                <div class="caption vertical-center text-left right" style="padding-right:0;">
                                    <div class="big-text fadeInDown-1">
                                        <?= $imagen_banner->descripcion_principal; ?>
                                    </div>

                                    <div class="excerpt fadeInDown-2">
                                        <?= $imagen_banner->descripcion_secundaria; ?>
                                    </div>
                                    <!-- <div class="button-holder fadeInDown-3">
                                                <a href="single-product.html" class="big le-button ">shop now</a>
                                            </div>-->
                                </div><!-- /.caption -->
                            </div><!-- /.container-fluid -->
                        </div><!-- /.item -->
                    <?php endforeach; ?>
                </div><!-- /.owl-carousel -->
            </div>
            <!-- ========================================= SECTION – HERO : END ========================================= -->
        </div>
    </div>
</div><!-- /.homepage2 -->

<!-- SECTION -->

<!-- /SECTION -->
<div id="products-tab" class="wow fadeInUp">
    <div class="container">
        <div class="tab-holder">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#featured" data-toggle="tab">Nuevos productos</a></li>
                <!--<li><a href="#new-arrivals" data-toggle="tab">new arrivals</a></li>
                            <li><a href="#top-sales" data-toggle="tab">top sales</a></li>-->
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="featured">

                    <?php foreach ($productos as $producto) : ?>
                        <div class="product-grid-holder">

                            <div class="col-sm-4 col-md-3  no-margin product-item-holder hover">
                                <div class="product-item">

                                    <?= empty($producto->productoDescuentos->descuento) ? '' : '<div class="ribbon red"><span>-' . $producto->productoDescuentos->descuento . '%</span></div>'; ?>
                                    <div class="image">
                                        <a target='_blank' href="<?= Url::to(['producto/detalle-producto', 'idProducto' => $producto->id, 'nombre' => $producto->nombre]) ?>"><img style="object-fit: contain; height: 200px;" alt="" src="<?php echo Yii::$app->request->baseUrl . '/img/core-img/'; ?>blank.gif" data-echo="<?php echo Yii::$app->request->baseUrl; ?>/imagenes/productos/<?= $producto->imagenPrincipalProductos->nombre_archivo ?>" /></a>
                                    </div>
                                    <div class="body">
                                        <div class="label-discount green"><a target="_blank" href="<?= Url::to(['producto/lista-jagao', 'proveedor' => $producto->proveedor->nombre]) ?>"><?= $producto->proveedor->nombre; ?></a></div>
                                        <div class="title">
                                            <a href="<?= Url::to(['producto/detalle-producto', 'idProducto' => $producto->id, 'nombre' => $producto->nombre]) ?>"><?= $producto->nombre ?></a>
                                        </div>
                                        <?php foreach ($producto->productoSubcategorias as $categoria) : ?>
                                            <div class="brand"><?= $categoria->subcategoria->nombre ?></div>
                                        <?php endforeach; ?>

                                    </div>
                                    <div class="prices" style="line-height: 1;">
                                        <div class="price-current pull-right"><?= 'COP $ ' . number_format($producto->precio_pesos, 2, ',', '.') ?></div>
                                        <?php if (!empty($producto->productoDescuentos->descuento)) :  ?>
                                            <div class="price-prev"><?= 'COP $' . number_format(($producto->precio_pesos * 100) / (100 - $producto->productoDescuentos->descuento), 2, ',', '.');  ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="hover-area">
                                        <div class="add-cart-button">
                                            <a href="<?= Url::to(['producto/detalle-producto', 'idProducto' => $producto->id, 'nombre' => $producto->nombre]) ?>" target="_blank" class="le-button">Agregar al carrito</a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<div class="loadmore-holder text-center">
    <a class="btn-loadmore" href="<?= Url::to(['producto/lista-jagao']) ?>" target="_blank">
        <i class="fa fa-plus"></i>
        Cargar más productos</a>
</div>
<!-- ========================================= BEST SELLERS ========================================= -->

<section id="bestsellers" class="color-bg wow fadeInUp">
    <div class="container">
        <h1 class="section-title">Más vendidos</h1>
        <div class="product-grid-holder medium">
            <div class="col-xs-12 col-md-12 no-margin">
                <div class="row no-margin">
                    <?php foreach ($mas_vendidos as $producto) : ?>
                        <div class="col-xs-12 col-sm-3 no-margin product-item-holder  hover">
                            <div class="product-item">
                                <div class="image">
                                    <a target='_blank' href="<?= Url::to(['producto/detalle-producto', 'idProducto' => $producto->producto->id, 'nombre' => $producto->producto->nombre]) ?>"><img style="object-fit: contain; height: 240px;" alt="" src="<?php echo Yii::$app->request->baseUrl . '/img/core-img/'; ?>blank.gif" data-echo="<?php echo Yii::$app->request->baseUrl; ?>/imagenes/productos/<?= $producto->producto->imagenPrincipalProductos->nombre_archivo ?>" /></a>
                                </div>
                                <div class="body">
                                    <div class="label-discount clear"><a target="_blank" href="<?= Url::to(['producto/lista-jagao', 'proveedor' => $producto->producto->proveedor->nombre]) ?>"><?= $producto->producto->proveedor->nombre; ?></a></div>
                                    <div class="title">
                                        <a href="<?= Url::to(['producto/detalle-producto', 'idProducto' => $producto->producto->id, 'nombre' => $producto->producto->nombre]) ?>"><?= $producto->producto->nombre ?></a>
                                    </div>
                                    <?php foreach ($producto->producto->productoCategorias as $categoria) : ?>
                                        <div class="brand"><?= $categoria->categoria->nombre ?></div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="prices" style="line-height: 1;">
                                    <div class="price-current pull-right"><?= 'COP $ ' . number_format($producto->producto->precio_pesos, 2, ',', '.') ?></div>
                                    <?php if (!empty($producto->producto->productoDescuentos->descuento)) :  ?>
                                        <div class="price-prev"><?= 'COP $' . number_format(($producto->producto->precio_pesos * 100) / (100 - $producto->producto->productoDescuentos->descuento), 2, ',', '.');  ?></div>
                                    <?php endif; ?>
                                </div><br>
                                <div class="hover-area">
                                    <div class="add-cart-button">
                                        <a href="<?= Url::to(['producto/detalle-producto', 'idProducto' => $producto->producto->id, 'nombre' => $producto->producto->nombre]) ?>" target="_blank" class="le-button">Agregar al carrito</a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.product-item-holder -->
                    <?php endforeach; ?>
                </div><!-- /.row -->


            </div><!-- /.col -->

        </div><!-- /.product-grid-holder -->
    </div><!-- /.container -->
</section><!-- /#bestsellers -->
<!-- ========================================= BEST SELLERS : END ========================================= -->




<!-- ========================================= RECENTLY VIEWED ========================================= -->

<!-- ============================================================= FOOTER : END ============================================================= -->
</div><!-- /.wrapper -->