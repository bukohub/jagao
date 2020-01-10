<?php

use frontend\controllers\ProductoController;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Mi carrito';
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="cart-page">
                <div class="container">
                    <!-- ========================================= CONTENT ========================================= -->
                    <div class="col-xs-12 col-md-9 items-holder no-margin">
                    <?=
                    Html::beginForm(Yii::$app->urlManager->createUrl(['producto/cambiar-carrito',]), '', ['class' => 'change_cart form-horizontal clearfix mb-50 d-flex']);
                    ?>                        
                    <?php foreach($list_cart as $product):  $item = Yii::$app->cart->getItem($product); if(!empty($item->getProduct()->producto->nombre)): ?>
                        <div class="row no-margin cart-item">
                            <div class="col-xs-12 col-sm-2 no-margin">
                                <a href="<?=Url::to(['producto/detalle-producto', 'idProducto' => $item->getProduct()->id,'nombre'=>$item->getProduct()->producto->nombre])?>" target="_blank" class="thumb-holder">
                                    <img class="lazy" alt="" src="<?= Yii::$app->request->baseUrl . '/imagenes/productos/' . $item->getProduct()->producto->imagenPrincipalProductos->nombre_archivo; ?>" />
                                </a>
                            </div>
                            <input type="text" name="id-producto[]" value="<?= $item->getProduct()->id; ?>" hidden>

                            <div class="col-xs-12 col-sm-5 ">
                                <div class="title">
                                    <a href="<?=Url::to(['producto/detalle-producto', 'idProducto' => $item->getProduct()->producto->id,'nombre'=>$item->getProduct()->producto->nombre])?>" target="_blank" ><?= $item->getProduct()->producto->nombre; ?></a>
                                </div>
                                <div class="brand">
                                    <div class="color-brand" style="background-color:<?=  $item->getProduct()->codigo_color; ?>;">
                                        <?=  $item->getProduct()->codigo_color; ?>
                                    </div>
                                    Talla: <?=  $item->getProduct()->talla->descripcion; ?>
                                </div>
                               
                            </div>

                            <div class="col-xs-12 col-sm-3 no-margin">
                                <div class="quantity">
                                    <div class="le-quantity">
                                            <a class="minus changing" href="#reduce"></a>
                                            <input data-refactory="<?= $item->getProduct()->id; ?>" name="quantity[]" readonly="readonly" type="text" value="<?= $item->getQuantity(); ?>" />
                                            <a class="plus changing" href="#add"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-2 no-margin">
                                <div class="price" data-protected ="<?= md5($item->getProduct()->id); ?>">
                                <?= 'COP $'.number_format($item->getProduct()->producto->precio_pesos * $item->getQuantity(), 0, ',', '.'); ?>
                                </div>
                                <a title="Eliminar" class="close-btn" data-trucate ="<?= ($item->getProduct()->id); ?>" href="javascript:void(0)"></a>
                            </div>
                        </div><!-- /.cart-item -->
                        <?php endif; endforeach; ?>
                        <?= Html::endForm(); ?>
                    </div>
                    <!-- ========================================= CONTENT : END ========================================= -->

                    <!-- ========================================= SIDEBAR ========================================= -->
                    <div class="col-xs-12 col-md-3 no-margin sidebar ">
                        <div class="widget cart-summary">
                            <h1 class="border">Carrito</h1>
                            <div class="body">
                                <ul class="tabled-data no-border inverse-bold">
                                    <li>
                                        <label>Subtotal carrito</label>
                                        <div class="value pull-right subtotal">$<?= number_format(ProductoController::getTotalCost(Yii::$app->cart), 0, ',', '.'); ?></div>
                                    </li>
                                    <li>
                                        <label>Envío</label>
                                        <?php  $total_shipping = ProductoController::totalShipping();  ?>
                                        <div class="shipping pull-right"><?= number_format($total_shipping, 0, ',', '.'); ?></div>
                                    </li>
                                </ul>
                                <ul id="total-price" class="tabled-data inverse-bold no-border">
                                    <li>
                                        <label>Orden total</label>
                                        <div class="value pull-right total_cost">$<?= number_format(ProductoController::getTotalCost(Yii::$app->cart) + $total_shipping, 0, ',', '.'); ?></div>
                                    </li>
                                </ul>
                                <div class="buttons-holder">
                                    <a class="le-button big validate_user" href="<?=Url::to(['informacion-compra/create'])?>">Comprar</a>
                                    <a class="simple-link block" href="<?=Url::to(['producto/lista-jagao'])?>" target="_blank">Continuar comprando</a>
                                </div>
                            </div>
                        </div><!-- /.widget -->

                        <!-- /.widget -->
                    </div><!-- /.sidebar -->
                    
                    <!-- ========================================= SIDEBAR : END ========================================= -->
                </div>
            </section>
            <script type="text/javascript" src="https://checkout.epayco.co/checkout.js">   </script>

