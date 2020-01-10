<?php

use frontend\models\Producto;
use yii\helpers\Html;
use yii\bootstrap\Modal;
?>
<div class="cart_area section_padding_100 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cart-table clearfix">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($carrito->getItemIds() as $id) {
                                $producto = Producto::findOne($id);
                                $item = $carrito->getItem($producto->id);
                                ?>
                                <tr>
                                    <td class="cart_product_img d-flex align-items-center">
                                        <?= Html::a('<img src="' . Yii::$app->request->baseUrl . '/imagenes/productos/' . $producto->imagenPrincipalProductos->nombre_archivo . '" alt="Product">', ['producto/detalle-producto', 'idProducto' => $producto->id], ['class' => "btn btn-sm btn-cart", 'target' => "_blank"]) ?>
                                        <h6><?= $producto->nombre ?></h6>
                                    </td>
                                    <td class="price"><span><?= 'COP $' . number_format($producto->precio_pesos, 0, ',', '.') ?></span></td>
                                    <td class="qty">
                                        <div class="quantity">
                                            <input type="number" class="qty-text" step="1" min="1" max="<?=$producto->cantidad_stock?>" name="quantity" value="<?= $item->getQuantity() ?>">
                                        </div>
                                    </td>
                                    <td class="total_price"><span><?= 'COP $' . number_format($item->getCost(), 0, ',', '.'); ?></span></td>
                                    <td class="text-center">
                                        <span>
                                            <input type="hidden" value="<?=$producto->id?>" class="input-id-producto">
                                            <a class="btn btn-danger btn-eliminar-producto" style="color:#fff;"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="cart-footer d-flex mt-30">
                    <div class="back-to-shop w-50">
                        <a href="shop-grid-left-sidebar.html">Continuar comprando</a>
                    </div>
                    <div class="update-checkout w-50 text-right">
                        <a href="#">Limpiar mi carrito</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
<!--            <div class="col-12 col-md-6 col-lg-4">
                <div class="coupon-code-area mt-70">
                    <div class="cart-page-heading">
                        <h5>Cupon code</h5>
                        <p>Enter your cupone code</p>
                    </div>
                    <form action="#">
                        <input type="search" name="search" placeholder="#569ab15">
                        <button type="submit">Apply</button>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="shipping-method-area mt-70">
                    <div class="cart-page-heading">
                        <h5>Shipping method</h5>
                        <p>Select the one you want</p>
                    </div>

                    <div class="custom-control custom-radio mb-30">
                        <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label d-flex align-items-center justify-content-between" for="customRadio1"><span>Next day delivery</span><span>$4.99</span></label>
                    </div>

                    <div class="custom-control custom-radio mb-30">
                        <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label d-flex align-items-center justify-content-between" for="customRadio2"><span>Standard delivery</span><span>$1.99</span></label>
                    </div>

                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label d-flex align-items-center justify-content-between" for="customRadio3"><span>Personal Pickup</span><span>Free</span></label>
                    </div>
                </div>
            </div>-->
            <div class="col-lg-12">
                <div class="cart-total-area mt-70">
                    <div class="cart-page-heading">
                        <h5>Total del carrito</h5>
                    </div>

                    <ul class="cart-total-chart">
                        <li><span>Subtotal</span> <span>$59.90</span></li>
                        <li><span><strong>Total</strong></span> <span><strong>$59.90</strong></span></li>
                    </ul>
                    <a href="checkout.html" class="btn karl-checkout-btn">Ir a pagar</a>
                </div>
            </div>
        </div>
    </div>
</div>