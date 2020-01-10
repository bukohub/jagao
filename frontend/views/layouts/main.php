<?php
/* @var $this \yii\web\View */
/* @var $content string */

use frontend\controllers\SiteController;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\controllers\ProductoController;
use yii\helpers\Url;
use frontend\models\AcercaJagao;
use frontend\models\Categoria;
use frontend\models\Proveedor;
use frontend\models\Subcategoria;
use yii\widgets\ActiveForm;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height,target-densitydpi=medium-dpi, user-scalable=0" />
    <meta name="description" content="Jagao sitio de ventas online">
    <meta name="author" content="JAGAO">
    <meta name="creator" content="rmrosero">
    <meta name="keywords" content="Jagao, eCommerce, Compras Online, Compras, Promociones">
    <meta name="robots" content="all">

    <title>JAGAO.CO | Tienda Virtual</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl; ?>/css/css_plantilla/bootstrap.min.css">

    <!-- Customizable CSS -->
    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl; ?>/css/css_plantilla/style.css">
    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl; ?>/css/css_plantilla/colors/green.css">
    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl; ?>/css/css_plantilla/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl; ?>/css/css_plantilla/owl.transitions.css">
    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl; ?>/css/css_plantilla/animate.min.css">
    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl; ?>/css/css_plantilla/izi.min.css">
    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl; ?>/css/css_plantilla/font-awesome.min.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/img/core-img/favicon.ico">

    <!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
<![endif]-->


</head>

<body>
    <div class="wrapper">
        <!-- ============================================================= TOP NAVIGATION ============================================================= -->
        <nav class="top-bar animate-dropdown">
            <div class="container">
                <div class="col-xs-12 col-sm-6 no-margin">
                    <ul>
                        <li><a href="<?= Url::to(['/']) ?>">Inicio</a></li>
                    </ul>
                </div><!-- /.col -->

                <div class="col-xs-12 col-sm-6 no-margin">
                    <ul class="right">

                        <?php if (Yii::$app->user->isGuest) { ?>
                            <li><a href="<?= Url::to(['site/login']) ?>"><i class="fa fa-id-card-o"></i> Ingresar</a></li>
                            <li><a href="<?= Url::to(['site/signup']) ?>"><i class="fa fa-user-plus"></i> Registrate</a></li>
                        <?php } else { ?>
                            <li><a href="<?= Url::to(['site/perfil']) ?>"><i class="fa fa-user-o"></i> Mi cuenta</a></li>
                        <?php } ?>
                    </ul>
                </div><!-- /.col -->
            </div><!-- /.container -->
        </nav><!-- /.top-bar -->
        <!-- ============================================================= TOP NAVIGATION : END ============================================================= -->

        <!-- ============================================================= HEADER ============================================================= -->
        <header class="no-padding-bottom header-alt">
            <div class="container no-padding">
                <div class="col-xs-12 col-md-3 logo-holder">
                    <!-- ============================================================= LOGO ============================================================= -->
                    <div class="logo">
                        <a href="<?= Url::to(['/']) ?>">
                            <img style="object-fit: contain;" alt="logo" src="<?php echo Yii::$app->request->baseUrl . '/img/core-img/' . 'isologotipo_horizontal_color.png' ?>" width="233" height="54" />
                        </a>
                    </div><!-- /.logo -->
                    <!-- ============================================================= LOGO : END ============================================================= -->
                </div><!-- /.logo-holder -->

                <div class="col-xs-12 col-md-6 top-search-holder no-margin">
                    <div class="contact-row">
                        <div class="phone inline">
                            <?php $a = AcercaJagao::find()->one(); ?>
                            <i class="fa fa-phone"></i> <?= $a->telefono; ?>
                        </div>
                        <div class="contact inline">
                            <i class="fa fa-envelope"></i> <?= $a->correo; ?>
                        </div>
                    </div><!-- /.contact-row -->
                    <!-- ============================================================= SEARCH AREA ============================================================= -->
                    <div class="search-area">
                        <?php ActiveForm::begin(['action' => Url::to(['producto/lista-jagao']), 'method' => 'get']) ?>

                        <div class="control-group">
                            <input class="search-field" name="query_txt" placeholder="Busca un producto en Jagao..." />

                            <ul class="categories-filter animate-dropdown">
                                <li class="dropdown">

                                    <a class="dropdown-toggle" data-toggle="dropdown" href="category-grid.html">Todo</a>

                                    <ul class="dropdown-menu" role="menu">
                                        <?php foreach (Categoria::find()->where(['estado'=>'Activo'])->all() as $categoria) : ?>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= Yii::$app->urlManager->createUrl('categoria/categoria-detalle', array('id' => $categoria->id)); ?>" target="_blank" class="dropdown-toggle"><?= $categoria->nombre; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            </ul>
                            <?= Html::submitButton('', ['class' => 'search-button']) ?>


                        </div>

                        <?php ActiveForm::end(); ?>
                    </div><!-- /.search-area -->
                    <!-- ============================================================= SEARCH AREA : END ============================================================= -->
                </div><!-- /.top-search-holder -->

                <div class="col-xs-12 col-md-3 top-cart-row no-margin">
                    <div class="top-cart-row-container">
                        <div class="wishlist-compare-holder">
                            <div class="wishlist ">
                                <!-- <a href="#"><i class="fa fa-heart"></i> wishlist <span class="value">(21)</span> </a>-->
                            </div>
                            <div class="compare">
                                <!--  <a href="#"><i class="fa fa-exchange"></i> compare <span class="value">(2)</span> </a>-->
                            </div>
                        </div>
                        <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
                        <div class="top-cart-holder dropdown animate-dropdown">
                            <div class="basket">

                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <div class="basket-item-count">
                                        <span class="count"><?= Yii::$app->cart->getTotalCount(); ?></span>
                                        <img src="<?php echo Yii::$app->request->baseUrl . '/img/core-img/' . '/icon-cart.png' ?>" alt="" />
                                    </div>
                                    <div class="total-price-basket">
                                        <span class="lbl">Tu carrito:</span>
                                        <span class="total-price">
                                            <span class="sign">$</span><span class="value"><?= number_format(ProductoController::getTotalCost(Yii::$app->cart), 0, ',', '.'); ?></span>
                                        </span>
                                    </div>
                                </a>

                                <ul class="dropdown-menu carrito" style="display:none;">
                                    <div class="produts"></div>
                                    <li class="checkout">
                                        <div class="basket-item">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6">
                                                    <?= Html::a('Carrito', ['/producto/list-cart'], ['class' => 'le-button inverse']) ?>
                                                </div>
                                                <div class="col-xs-12 col-sm-6">
                                                <form id="frm_botonePayco2" class='epayco' name="frm_botonePayco2" method="post" action="https://secure.payco.co/checkout.php">
                                                </form>
                                                <button class="le-button comprar">Comprar</button>

                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div><!-- /.basket -->
                        </div><!-- /.top-cart-holder -->
                    </div><!-- /.top-cart-row-container -->
                    <!-- ============================================================= SHOPPING CART DROPDOWN : END ============================================================= -->
                </div><!-- /.top-cart-row -->
            </div><!-- /.container -->

            <!-- ========================================= NAVIGATION ========================================= -->
            <nav id="top-megamenu-nav" class="megamenu-vertical animate-dropdown">
                <div class="container">
                    <div class="yamm navbar">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mc-horizontal-menu-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div><!-- /.navbar-header -->
                        <div class="collapse navbar-collapse" id="mc-horizontal-menu-collapse">
                            <ul class="nav navbar-nav">
                                <?php 
                                $categories = Categoria::find()->where(['estado'=>'Activo'])->all();
                                foreach ( $categories as $categoria) : ?>
                                    <li class="dropdown">
                                        <a data-hover="dropdown" href="<?= Url::to(['categoria/categoria-detalle', 'id' => $categoria->id ,'categoria'=>$categoria->nombre]) ?>" target="_blank" class="dropdown-toggle"><?= $categoria->nombre; ?></a>
                                     <?php $subcategorias = Subcategoria::find()->where(['categoria_id'=>$categoria->id])->all();  
                                            if(!empty($subcategorias)):         
                                     ?>
                                            <ul class="dropdown-menu">
                                                <?php foreach($subcategorias as $subcategoria): ?>
                                                <li><a href="<?= Url::to(['categoria/categoria-detalle', 'sub' => $subcategoria->id,'categoria'=>$subcategoria->nombre]) ?>"><?= $subcategoria->nombre; ?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <?php endif;?>
                                    </li>
                                <?php endforeach; ?>

                            </ul><!-- /.navbar-nav -->
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.navbar -->
                </div><!-- /.container -->
            </nav><!-- /.megamenu-vertical -->
            <!-- ========================================= NAVIGATION : END ========================================= -->
        </header>
        <!-- ============================================================= HEADER : END ============================================================= -->


        <!-- ========================================= HOME BANNERS ========================================= -->
        <!-- /#banner-holder -->
        <!-- ========================================= HOME BANNERS : END ========================================= -->
        <?=
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ])
        ?>
        <div class="col-sm-12">
            <?= Alert::widget() ?>
        </div>
        <?= $content ?>

        <!-- ========================================= RECENTLY VIEWED : END ========================================= -->


        <!-- HOT DEAL SECTION -->
        <!-- ========================================= TOP BRANDS ========================================= -->
        <section id="top-brands" class="wow fadeInUp">
            <div class="container">
                <div class="carousel-holder">

                    <div class="title-nav">
                        <h1>Nuestros Proveedores</h1>
                        <div class="nav-holder">
                            <a href="#prev" data-target="#owl-brands" class="slider-prev btn-prev fa fa-angle-left"></a>
                            <a href="#next" data-target="#owl-brands" class="slider-next btn-next fa fa-angle-right"></a>
                        </div>
                    </div><!-- /.title-nav -->

                    <div id="owl-brands" class="owl-carousel brands-carousel">
                        <?php foreach(Proveedor::find()->where(['estado_id'=>"1"])->orderBy(['creado_el' => SORT_DESC])->all() as $proveedor):  ?>
                        <div class="carousel-item">                        
                            <a href="<?=Url::to(['producto/lista-jagao', 'proveedor' => $proveedor->nombre ])?>" target="_blank">
                                <img alt="" src="<?php echo Yii::$app->request->baseUrl; ?>/imagenes/proveedores/<?= $proveedor->imagenProveedors->nombre_archivo?>" />
                            </a>
                        </div><!-- /.carousel-item -->
                         <?php endforeach;?>
                    </div><!-- /.brands-caresoul -->

                </div><!-- /.carousel-holder -->
            </div><!-- /.container -->
        </section><!-- /#top-brands -->
        <!-- ========================================= TOP BRANDS : END ========================================= -->

        <!-- ============================================================= FOOTER ============================================================= -->
        <footer id="footer" class="color-bg">
            <div class="container">
                <div class="row no-margin widgets-row">
                    <div class="col-xs-12  col-sm-4 no-margin-left">
                        <!-- ============================================================= FEATURED PRODUCTS ============================================================= -->
                        <div class="widget">
                            <h2>Productos Destacados</h2>
                            <div class="body">
                                <ul>
                                    <li>
                                        <div class="row">
                                            <?php foreach(SiteController::destacados() as $destacado): ?>
                                            <div class="col-xs-12 col-sm-9 no-margin">
                                                <a href="<?=Url::to(['producto/detalle-producto', 'idProducto' => $destacado->producto->id])?>" target="_blank"><?= $destacado->producto->nombre; ?></a>.
                                                <div class="price">
                                                    <?php if(!empty($destacado->producto->productoDescuentos->descuento)):  ?>
                                                    <div class="price-prev"><?= 'COP $'.number_format( ($destacado->producto->precio_pesos*100)/(100-$destacado->producto->productoDescuentos->descuento),2,',', '.');  ?></div>
                                                    <?php endif;?>
                                                    <div class="price-current" ><?= 'COP $ ' . number_format($destacado->producto->precio_pesos, 2, ',', '.') ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-3 no-margin">
                                                <a href="<?=Url::to(['producto/detalle-producto', 'idProducto' => $destacado->producto->id])?>" class="thumb-holder">
                                                    <img alt="" src="<?php echo Yii::$app->request->baseUrl.'/img/core-img/'; ?>blank.gif" data-echo="<?php echo Yii::$app->request->baseUrl; ?>/imagenes/productos/<?= $destacado->producto->imagenPrincipalProductos->nombre_archivo?>" />
                                                </a>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </li>
                                </ul>
                            </div><!-- /.body -->
                        </div> <!-- /.widget -->
                        <!-- ============================================================= FEATURED PRODUCTS : END ============================================================= -->
                    </div><!-- /.col -->

                    <div class="col-xs-12 col-sm-4 ">
                        <!-- ============================================================= ON SALE PRODUCTS ============================================================= -->
                        <div class="widget">
                            <h2>Productos con Descuentos</h2>
                            <div class="body">
                                <ul>
                               
                                    <li>
                                        <div class="row">
                                        <?php foreach(SiteController::descuentos() as $destacado): ?>
                                            <div class="col-xs-12 col-sm-9 no-margin">
                                                <a href="<?=Url::to(['producto/detalle-producto', 'idProducto' => $destacado->producto->id])?>" target="_blank"><?= $destacado->producto->nombre; ?></a>.
                                                <div class="price">
                                                    <?php if(!empty($destacado->producto->productoDescuentos->descuento)):  ?>
                                                    <div class="price-prev"><?= 'COP $'.number_format( ($destacado->producto->precio_pesos*100)/(100-$destacado->producto->productoDescuentos->descuento),2,',', '.');  ?></div>
                                                    <?php endif;?>
                                                    <div class="price-current" ><?= 'COP $ ' . number_format($destacado->producto->precio_pesos, 2, ',', '.') ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-3 no-margin">
                                                <a href="<?=Url::to(['producto/detalle-producto', 'idProducto' => $destacado->producto->id])?>" class="thumb-holder">
                                                    <img alt="" src="<?php echo Yii::$app->request->baseUrl.'/img/core-img/'; ?>blank.gif" data-echo="<?php echo Yii::$app->request->baseUrl; ?>/imagenes/productos/<?= $destacado->producto->imagenPrincipalProductos->nombre_archivo?>" />
                                                </a>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </li>
                                </ul>
                            </div><!-- /.body -->
                        </div> <!-- /.widget -->
                        <!-- ============================================================= ON SALE PRODUCTS : END ============================================================= -->
                    </div><!-- /.col -->

                   
                </div><!-- /.widgets-row-->
            </div><!-- /.container -->

            <div class="sub-form-row">
                <div class="container">
                    <div class="col-xs-12 col-sm-8 col-sm-offset-2 no-padding">
                        <form role="form">
                          <!--  <input placeholder="Suscríbete a nuestro newsletter">
                            <button class="le-button">Suscríbete</button>-->
                        </form>
                    </div>
                </div><!-- /.container -->
            </div><!-- /.sub-form-row -->

            <div class="link-list-row">
                <div class="container no-padding">
                    <div class="col-xs-12 col-md-4 ">
                        <!-- ============================================================= CONTACT INFO ============================================================= -->
                        <div class="contact-info">
                            <div class="footer-logo">
                                <a href="<?= Url::to(['/']) ?>">
                                    <img style="object-fit: contain;" alt="logo" src="<?php echo Yii::$app->request->baseUrl . '/img/core-img/' . 'isologotipo_horizontal_color.png' ?>" width="233" height="54" />
                                </a>
                            </div><!-- /.footer-logo -->

                            <p class="regular-bold">Siéntete libre de contactarnos vía email.</p>

                            <p>
                            <?= $a->direccion; ?>
                            </p>

                            <div class="social-icons">
                                <h3>Encuéntranos en:</h3>
                                <ul>
                                    <?php if(!empty( $a->facebook)): ?>                                    
                                    <li><a target="_blank" href="<?= $a->facebook; ?>" class="fa fa-facebook"></a></li>
                                     <?php endif; ?>
                                     <?php if(!empty( $a->telefono)): ?>                                    
                                    <li><a target="_blank" href="https://wa.me/57<?= $a->telefono; ?>" class="fa fa-whatsapp"></a></li>
                                     <?php endif; ?>
                                     <?php if(!empty( $a->instagram)): ?>                                    
                                    <li><a target="_blank" href="<?= $a->instagram; ?>" class="fa fa-instagram"></a></li>
                                     <?php endif; ?>
                                </ul>
                            </div><!-- /.social-icons -->

                        </div>
                        <!-- ============================================================= CONTACT INFO : END ============================================================= -->
                    </div>

                    <div class="col-xs-12 col-md-8 no-margin">
                        <!-- ============================================================= LINKS FOOTER ============================================================= -->
                        <div class="link-widget">
                            <div class="widget">
                                <h3>Encuentra rápidamente</h3>
                                <ul>
                                    <?php $i = 0;                                   
                                    $suffle     = $categories;
                                    shuffle($suffle);  ?>
                                    <?php foreach ($suffle as $categoria) : ?>
                                        <?php if ($i < 8) :  ?>
                                            <li><a href="<?= Yii::$app->urlManager->createUrl('categoria/categoria-detalle', array('id' => $categoria->id)); ?>" target="_blank"><?= $categoria->nombre; ?></a></li>
                                        <?php endif; ?>
                                    <?php $i++;
                                    endforeach; ?>
                                </ul>
                            </div><!-- /.widget -->
                        </div><!-- /.link-widget -->

                        <div class="link-widget">
                            <div class="widget">
                                <h3>Información de JAGAO</h3>
                                <ul>
                                    <li><a href="<?= Url::to(['site/acerca-jagao']) ?>">Acerca de nosostros</a></li>
                                    <li><a href="<?= Url::to(['terminos-jagao/terminos-usuario']) ?>">Nuestros términos y condiciones y política de tratamiento de datos</a></li>
                                  <!--  <li><a href="category-grid.html">Contáctanos</a></li>-->
                                </ul>
                            </div><!-- /.widget -->
                        </div><!-- /.link-widget -->

                        <div class="link-widget">
                            <div class="widget">
                                <h3>Mi información</h3>
                                <ul>
                                    <li><a href="<?= Url::to(['site/perfil']) ?>">Mi cuenta</a></li>
                                </ul>
                            </div><!-- /.widget -->
                        </div><!-- /.link-widget -->
                        <!-- ============================================================= LINKS FOOTER : END ============================================================= -->
                    </div>
                </div><!-- /.container -->
            </div><!-- /.link-list-row -->

            <div class="copyright-bar">
                <div class="container">
                    <div class="col-xs-12 col-sm-6 no-margin">
                        <div class="copyright">
                            &copy; <a href="index.html">JAGAO</a> - todos los derechos reservados
                        </div><!-- /.copyright -->
                    </div>
                    <div class="col-xs-12 col-sm-6 no-margin">
                        <div class="payment-methods ">
                                <a href="https://epayco.co/medios_de_pago_epayco.php" target="_blank">Nuestros medios de pago</a>
                        </div><!-- /.payment-methods -->
                    </div>
                </div><!-- /.container -->
            </div><!-- /.copyright-bar -->
        </footer><!-- /#footer -->

        <div id="loading-screen" class="hidden">
            <div align="center" class="cssload-fond">
                <div class="cssload-container-general">
                    <div class="cssload-internal">
                        <div class="cssload-ballcolor cssload-ball_1"> </div>
                    </div>
                    <div class="cssload-internal">
                        <div class="cssload-ballcolor cssload-ball_2"> </div>
                    </div>
                    <div class="cssload-internal">
                        <div class="cssload-ballcolor cssload-ball_3"> </div>
                    </div>
                    <div class="cssload-internal">
                        <div class="cssload-ballcolor cssload-ball_4"> </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.wrapper end -->
        <div id="modal">
            <div class="modal-btns">
                <p>Agregaste un producto a tu carrito</p>
                <?= Html::a('Finalizar Compra', ['/carrito'], ['class' => 'btn btn-lg le-button']) ?>
                <button class="btn btn-lg " data-izimodal-close="">Seguir comprando</button>
            </div>
        </div>

        <div id="modalerror">
            <div class="modal-btns">
                <p><b><span id="data_error"></span> </b></p>
                <button class="btn btn-lg " data-izimodal-close="">Cerrar</button>
            </div>
        </div>
        <div id="modalsucess">
            <div class="modal-btns">
                <p><b><span id="data_success"></span> </b></p>
                <button class="btn btn-lg " data-izimodal-close="">Cerrar</button>
            </div>
        </div>

        <div id="validation_cart">
            <div class="modal-btns">
                <input type="hidden" id="refactory">
                <p><b><span id="data_refact"></span> </b></p>
                <button class="btn btn-lg le-button" id="aceptar-delete" >Aceptar</button>
                <button class="btn btn-lg " data-izimodal-close="">Cancelar</button>
            </div>
        </div>
        <script src="//maps.google.com/maps/api/js?key=AIzaSyDDZJO4F0d17RnFoi1F2qtw4wn6Wcaqxao&sensor=false&amp;language=en"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/jquery-1.10.2.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/jquery-migrate-1.2.1.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/bootstrap.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/gmap3.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/bootstrap-hover-dropdown.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/owl.carousel.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/css_browser_selector.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/echo.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/jquery.easing-1.3.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/bootstrap-slider.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/jquery.raty.min.js?v=1.0"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/jquery.prettyPhoto.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/jquery.customSelect.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/wow.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/izimodal.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/buttons.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/scripts.js"></script>
        <!--<script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/main.js"></script>-->

        <script>
            $.ajaxSetup({
                data: <?=
                            \yii\helpers\Json::encode([
                                \yii::$app->request->csrfParam => \yii::$app->request->csrfToken,
                            ])
                        ?>
            });
        </script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/carrito.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/direccion.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/frontend.js"></script>
        <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"> </script>

        <script>
            var url_ = '<?php echo Yii::$app->request->baseUrl ?>';
            $('form').submit(function() {
                var button = $(this).find(':submit');
                button.prepend('<i class="fa fa-spinner fa-spin mr-1"></i>');
                button.attr('disabled', true);
            });
        </script>
</body>

</html>
<?php $this->endPage() ?>