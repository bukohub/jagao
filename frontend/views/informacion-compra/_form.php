<?php

use frontend\controllers\ProductoController;
use frontend\models\Pais;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\InformacionCompra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="informacion-compra-form">
    <?php $form = ActiveForm::begin(['id' => 'pay_cart']); ?>
    <div class="animate-dropdown">
        <!-- ========================================= BREADCRUMB ========================================= -->
        <div id="top-mega-nav">
            <div class="container">
                <nav>
                    <ul class="inline">
                        <li class="breadcrumb-nav-holder">
                            <ul>
                                <li class="breadcrumb-item current gray">
                                    <a href="#">Proceso de Checkout</a>
                                </li>
                            </ul>
                        </li><!-- /.breadcrumb-nav-holder -->
                    </ul>
                </nav>
            </div><!-- /.container -->
        </div><!-- /#top-mega-nav -->
        <!-- ========================================= BREADCRUMB : END ========================================= -->
    </div>

    <section id="checkout-page">
        <div class="container">
            <div class="col-xs-12 no-margin">

                <div class="billing-address">
                    <h2 class="border h1">Dirección de Envío</h2>
                   
                        <div class="row field-row">
                            <div class="col-xs-12 col-sm-6">
                                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'class' => 'le-input', 'value' =>@Yii::$app->user->identity->name]) ?>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?= $form->field($model, 'apellido')->textInput(['maxlength' => true, 'class' => 'le-input', 'value' => @Yii::$app->user->identity->surname]) ?>
                            </div>
                        </div><!-- /.field-row -->

                        <div class="row field-row">
                            <div class="col-xs-12 col-sm-6">
                                <?= $form->field($model, 'cedula')->textInput(['maxlength' => true, 'class' => 'le-input', 'type' => 'number']) ?>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?= $form->field($model, 'direccion')->textInput(['maxlength' => true, 'class' => 'le-input']) ?>
                            </div>
                        </div><!-- /.field-row -->

                        <div class="row field-row">

                            <div class="col-xs-12 col-sm-6">
                                <?= $form->field($model, 'id_pais')->dropDownList(ArrayHelper::map(Pais::find()->orderBy('nombre ASC')->all(), 'id', 'nombre'),  ['id' => 'id_pais', 'prompt' => 'Seleccione un País']) ?>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?= $form->field($model, 'id_depto')->dropDownList([],  ['id' => 'id_depto', 'prompt' => 'Seleccione un departamento']) ?>
                            </div>
                        </div><!-- /.field-row -->

                        <div class="row field-row">
                            <div class="col-xs-12 col-sm-6">
                                <?= $form->field($model, 'id_ciudad')->dropDownList([],  ['id' => 'id_ciudad', 'prompt' => 'Seleccione una ciudad']) ?>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?= $form->field($model, 'telefono')->textInput(['maxlength' => true, 'class' => 'le-input', 'type' => 'number']) ?>
                            </div>
                        </div>
                        <div class="row field-row">
                            <div class="col-xs-12">
                                <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'class' => 'le-input', 'value' => @Yii::$app->user->identity->email]) ?>
                            </div>
                        </div><!-- /.field-row -->
                        <!-- /.field-row -->

                  
                </div><!-- /.billing-address -->




                <section id="your-order">
                    <h2 class="border h1">Tu Orden</h2>
                   
                         <?php foreach(Yii::$app->cart->getItemIds() as $product):  $item = Yii::$app->cart->getItem($product); if(!empty($item->getProduct()->producto->nombre)): ?>
                        <div class="row no-margin order-item">
                            <div class="col-xs-12 col-sm-1 no-margin">
                                <a href="#" class="qty"><?= $item->getQuantity(); ?> x</a>
                            </div>

                            <div class="col-xs-12 col-sm-9 ">
                                <div class="title"><a href="<?=Url::to(['producto/detalle-producto', 'idProducto' => $item->getProduct()->producto->id,'nombre'=>$item->getProduct()->producto->nombre])?>" target="_blank"><?= $item->getProduct()->producto->nombre; ?> </a></div>
                                <div class="brand">
                                    <div class="color-brand" style="background-color:<?=  $item->getProduct()->codigo_color; ?>;">
                                        <?=  $item->getProduct()->codigo_color; ?>
                                    </div>
                                    Talla: <?=  $item->getProduct()->talla->descripcion; ?>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-2 no-margin">
                                <div class="price">   <?= 'COP $'.number_format($item->getProduct()->producto->precio_pesos, 0, ',', '.'); ?></div>
                            </div>
                        </div><!-- /.order-item -->
                        <?php endif; endforeach; ?>
                    
                </section><!-- /#your-order -->

                <div id="total-area" class="row no-margin">
                    <div class="col-xs-12 col-lg-4 col-lg-offset-8 no-margin-right">
                        <div id="subtotal-holder">
                            <ul class="tabled-data inverse-bold no-border">
                                <li>
                                    <label>Subtotal Carrito</label>
                                    <div class="value ">$<?= number_format(ProductoController::getTotalCost(Yii::$app->cart), 0, ',', '.'); ?></div>
                                </li>
                                <li>
                                    <label>Envío</label>
                                    <div class="value">
                                        <div class="radio-group">
                                            <input class="le-radio" type="radio" name="group1" value="local" checked>
                                            <div class="radio-label"><span class="bold">$<?= number_format(ProductoController::totalShipping(), 0, ',', '.'); ?></span></div>
                                        </div>
                                    </div>
                                </li>
                            </ul><!-- /.tabled-data -->

                            <ul id="total-field" class="tabled-data inverse-bold ">
                                <li>
                                    <label>Orden Total</label>
                                    <div class="value">$<?= number_format(ProductoController::getTotalCost(Yii::$app->cart) + ProductoController::totalShipping(), 0, ',', '.'); ?></div>
                                </li>
                            </ul><!-- /.tabled-data -->

                        </div><!-- /#subtotal-holder -->
                    </div><!-- /.col -->
                </div><!-- /#total-area -->



                <div class="place-order-button">
                    <?= Html::submitButton('Comprar', ['class' => 'le-button bi']) ?>
                </div><!-- /.place-order-button -->

            </div><!-- /.col -->
        </div><!-- /.container -->
    </section>



    <?php ActiveForm::end();

    ?>
           


</div>