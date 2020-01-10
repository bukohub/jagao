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
                            <form>
                                <div class="row field-row">
                                    <div class="col-xs-12 col-sm-6">
                                        <label>Nombre*</label>
                                        <input class="le-input" value="<?= @Yii::$app->user->identity->username; ?>">
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <label>last name*</label>
                                        <input class="le-input" >
                                    </div>
                                </div><!-- /.field-row -->

                                <div class="row field-row">
                                    <div class="col-xs-12">
                                        <label>company name</label>
                                        <input class="le-input" >
                                    </div>
                                </div><!-- /.field-row -->

                                <div class="row field-row">
                                    <div class="col-xs-12 col-sm-6">
                                        <label>address*</label>
                                        <input class="le-input" data-placeholder="street address" >
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <label>&nbsp;</label>
                                        <input class="le-input" data-placeholder="town" >
                                    </div>
                                </div><!-- /.field-row -->

                                <div class="row field-row">
                                    <div class="col-xs-12 col-sm-4">
                                        <label>email address*</label>
                                        <input class="le-input" >
                                    </div>

                                    <div class="col-xs-12 col-sm-4">
                                        <label>phone number*</label>
                                        <input class="le-input" >
                                    </div>
                                </div><!-- /.field-row -->
<!-- /.field-row -->

                            </form>
                        </div><!-- /.billing-address -->




                        <section id="your-order">
                            <h2 class="border h1">Tu Orden</h2>
                            <form>
                                <div class="row no-margin order-item">
                                    <div class="col-xs-12 col-sm-1 no-margin">
                                        <a href="#" class="qty">1 x</a>
                                    </div>

                                    <div class="col-xs-12 col-sm-9 ">
                                        <div class="title"><a href="#">white lumia 9001 </a></div>
                                        <div class="brand">sony</div>
                                    </div>

                                    <div class="col-xs-12 col-sm-2 no-margin">
                                        <div class="price">$2000.00</div>
                                    </div>
                                </div><!-- /.order-item -->

                                <div class="row no-margin order-item">
                                    <div class="col-xs-12 col-sm-1 no-margin">
                                        <a href="#" class="qty">1 x</a>
                                    </div>

                                    <div class="col-xs-12 col-sm-9 ">
                                        <div class="title"><a href="#">white lumia 9001 </a></div>
                                        <div class="brand">sony</div>
                                    </div>

                                    <div class="col-xs-12 col-sm-2 no-margin">
                                        <div class="price">$2000.00</div>
                                    </div>
                                </div><!-- /.order-item -->

                                <div class="row no-margin order-item">
                                    <div class="col-xs-12 col-sm-1 no-margin">
                                        <a href="#" class="qty">1 x</a>
                                    </div>

                                    <div class="col-xs-12 col-sm-9 ">
                                        <div class="title"><a href="#">white lumia 9001 </a></div>
                                        <div class="brand">sony</div>
                                    </div>

                                    <div class="col-xs-12 col-sm-2 no-margin">
                                        <div class="price">$2000.00</div>
                                    </div>
                                </div><!-- /.order-item -->
                            </form>
                        </section><!-- /#your-order -->

                        <div id="total-area" class="row no-margin">
                            <div class="col-xs-12 col-lg-4 col-lg-offset-8 no-margin-right">
                                <div id="subtotal-holder">
                                    <ul class="tabled-data inverse-bold no-border">
                                        <li>
                                            <label>cart subtotal</label>
                                            <div class="value ">$8434.00</div>
                                        </li>
                                        <li>
                                            <label>shipping</label>
                                            <div class="value">
                                                <div class="radio-group">
                                                    <input class="le-radio" type="radio" name="group1" value="free"> <div class="radio-label bold">free shipping</div><br>
                                                    <input class="le-radio" type="radio" name="group1" value="local" checked>  <div class="radio-label">local delivery<br><span class="bold">$15</span></div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul><!-- /.tabled-data -->

                                    <ul id="total-field" class="tabled-data inverse-bold ">
                                        <li>
                                            <label>order total</label>
                                            <div class="value">$8434.00</div>
                                        </li>
                                    </ul><!-- /.tabled-data -->

                                </div><!-- /#subtotal-holder -->
                            </div><!-- /.col -->
                        </div><!-- /#total-area -->



                        <div class="place-order-button">
                            <button class="le-button big">Comprar</button>
                        </div><!-- /.place-order-button -->

                    </div><!-- /.col -->
                </div><!-- /.container -->
            </section>