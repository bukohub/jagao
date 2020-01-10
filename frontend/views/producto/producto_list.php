<?php
   /* @var $this yii\web\View */
   
   $this->title = 'Búsqueda Productos';
   use yii\helpers\Html;
   use yii\widgets\LinkPager;
   use yii\helpers\Url;
   use yii\widgets\ActiveForm;
   ?>
        <div class="wrapper">


            <section id="category-grid">
                <div class="container">
                    <!-- ========================================= SIDEBAR ========================================= -->
                  
                    <!-- ========================================= SIDEBAR : END ========================================= -->

                    <!-- ========================================= CONTENT ========================================= -->
                    <div class="col-xs-12 col-sm-12 no-margin wide sidebar">
                     
                        <section id="gaming">
                            <div class="grid-list-products">
                                <h2 class="section-title"><?= @$producto_categoria[0]->categoria->nombre; ?></h2>
<!--
                                <div class="control-bar">
                                    <div id="popularity-sort" class="le-select" >
                                        <select data-placeholder="sort by popularity">
                                            <option value="1">1-100 players</option>
                                            <option value="2">101-200 players</option>
                                            <option value="3">200+ players</option>
                                        </select>
                                    </div>

                                    <div id="item-count" class="le-select">
                                        <select>
                                            <option value="1">24 per page</option>
                                            <option value="2">48 per page</option>
                                            <option value="3">32 per page</option>
                                        </select>
                                    </div>

                                    <div class="grid-list-buttons">
                                        <ul>
                                            <li class="grid-list-button-item active"><a data-toggle="tab" href="#grid-view"><i class="fa fa-th-large"></i> Grid</a></li>
                                            <li class="grid-list-button-item "><a data-toggle="tab" href="#list-view"><i class="fa fa-th-list"></i> List</a></li>
                                        </ul>
                                    </div>
                                </div>-->
                                <ul class="nav nav-tabs" >
                            <li><a href="#featured" data-toggle="tab"><?= !isset($_GET['proveedor']) ? 'Resultado Búsqueda' : $_GET['proveedor'].''; ?></a></li>
                            <!--<li><a href="#new-arrivals" data-toggle="tab">new arrivals</a></li>
                            <li><a href="#top-sales" data-toggle="tab">top sales</a></li>-->
                        </ul><br>

                                <div class="tab-content">
                                    
                                    <div id="grid-view" class="products-grid fade tab-pane in active">
                                    <?= (empty($producto_categoria) and isset($_GET['proveedor'])) ? '<h4>¡Ups! No se encontraron productos para este proveedor.</h4>' : (empty($producto_categoria) ?   '<h4>¡Ups! No se encontraron productos.</h4>' : NULL); ?>
                                        <div class="product-grid-holder container">
                                            <div class="row no-margin">
                                            <?php foreach($producto_categoria as $prod_categ): ?>
                                                <div class="col-xs-12 col-sm-3 no-margin product-item-holder hover">
                                                    <div class="product-item">
                                                    <?= empty($prod_categ->productoDescuentos->descuento) ? '' : '<div class="ribbon red"><span>-'.$prod_categ->productoDescuentos->descuento.'%</span></div>'; ?>  
                                                        <div class="image">
                                                        <a target='_blank' href="<?=Url::to(['producto/detalle-producto', 'idProducto' => $prod_categ->id,'nombre'=>$prod_categ->nombre])?>"><img style="object-fit: contain; height: 200px;" alt="" src="<?php echo Yii::$app->request->baseUrl.'/img/core-img/'; ?>blank.gif" data-echo="<?php echo Yii::$app->request->baseUrl; ?>/imagenes/productos/<?= $prod_categ->imagenPrincipalProductos->nombre_archivo?>" /></a>
                                                        </div>
                                                        <div class="body">
                                                        <div class="label-discount green"><a target="_blank" href="<?=Url::to(['producto/lista-jagao', 'proveedor' => $prod_categ->proveedor->nombre ])?>"><?= $prod_categ->proveedor->nombre; ?></a></div>
                                                            <div class="title">
                                                                <a href="<?=Url::to(['producto/detalle-producto', 'idProducto' => $prod_categ->id,'nombre'=>$prod_categ->nombre])?>"><?= $prod_categ->nombre; ?></a>
                                                            </div>
                                                            <?php foreach ($prod_categ->categoria as $categoria): ?>
                                                            <div class="brand"><?= $categoria->nombre; ?></div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <div class="prices">
                                                        <?php if(!empty($prod_categ->productoDescuentos->descuento)):  ?>
                                             <div class="price-prev"><?= 'COP $'.number_format( ($prod_categ->precio_pesos*100)/(100-$prod_categ->productoDescuentos->descuento),2,',', '.');  ?></div>
                                             <?php endif;?>
                                                            <div class="price-current pull-right"><?= 'COP $ ' . number_format($prod_categ->precio_pesos, 2, ',', '.'); ?></div>
                                                        </div>
                                                        <div class="hover-area">
                                                            <div class="add-cart-button">
                                                                <a href="<?=Url::to(['producto/detalle-producto', 'idProducto' => $prod_categ->id,'nombre'=>$prod_categ->nombre])?>" target="_blank" class="le-button">Añadir al carrito</a>
                                                            </div>
                                                            
                                                        </div>
                                                    </div><!-- /.product-item -->
                                                </div><!-- /.product-item-holder -->
                                            <?php endforeach;  ?>
                                            </div><!-- /.row -->
                                        </div><!-- /.product-grid-holder -->
                
                                        <div class="pagination-holder">
                                            <div class="row">
                                                            
                                                <div class="col-xs-12 col-sm-6 text-left">
                               
                                                <?php echo LinkPager::widget([
    'pagination' => $pagination,
    'activePageCssClass'=>'current',
    'nextPageLabel'=>'Siguiente'
]); ?>
                                                </div>

                                                <!--<div class="col-xs-12 col-sm-6">
                                                    <div class="result-counter">
                                                        MOstra <span>1-9</span> of <span>11</span> results
                                                    </div>
                                                </div>-->

                                            </div><!-- /.row -->
                                        </div><!-- /.pagination-holder -->
                                    </div><!-- /.products-grid #grid-view -->

                                    <div id="list-view" class="products-grid fade tab-pane ">
                                        <div class="products-list">

                                            <div class="product-item product-item-holder">
                                                <div class="ribbon red"><span>sale</span></div>
                                                <div class="ribbon blue"><span>new!</span></div>
                                                <div class="row">
                                                    <div class="no-margin col-xs-12 col-sm-4 image-holder">
                                                        <div class="image">
                                                            <img alt="" src="assets/images/blank.gif" data-echo="assets/images/products/product-01.jpg" />
                                                        </div>
                                                    </div><!-- /.image-holder -->
                                                    <div class="no-margin col-xs-12 col-sm-5 body-holder">
                                                        <div class="body">
                                                            <div class="label-discount green">-50% sale</div>
                                                            <div class="title">
                                                                <a href="single-product.html">VAIO Fit Laptop - Windows 8 SVF14322CXW</a>
                                                            </div>
                                                            <div class="brand">sony</div>
                                                            <div class="excerpt">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut lobortis euismod erat sit amet porta. Etiam venenatis ac diam ac tristique. Morbi accumsan consectetur odio ut tincidunt.</p>
                                                            </div>
                                                            
                                                        </div>
                                                    </div><!-- /.body-holder -->
                                                    <div class="no-margin col-xs-12 col-sm-3 price-area">
                                                        <div class="right-clmn">
                                                            <div class="price-current">$1199.00</div>
                                                            <div class="price-prev">$1399.00</div>
                                                            <div class="availability"><label>availability:</label><span class="available">  in stock</span></div>
                                                            <a class="le-button" href="#">add to cart</a>
                                                            <a class="btn-add-to-wishlist" href="#">add to wishlist</a>
                                                        </div>
                                                    </div><!-- /.price-area -->
                                                </div><!-- /.row -->
                                            </div><!-- /.product-item -->


                                            <div class="product-item product-item-holder">
                                                <div class="ribbon green"><span>bestseller</span></div>
                                                <div class="row">
                                                    <div class="no-margin col-xs-12 col-sm-4 image-holder">
                                                        <div class="image">
                                                            <img alt="" src="assets/images/blank.gif" data-echo="assets/images/products/product-02.jpg" />
                                                        </div>
                                                    </div><!-- /.image-holder -->
                                                    <div class="no-margin col-xs-12 col-sm-5 body-holder">
                                                        <div class="body">
                                                            <div class="label-discount clear"></div>
                                                            <div class="title">
                                                                <a href="single-product.html">VAIO Fit Laptop - Windows 8 SVF14322CXW</a>
                                                            </div>
                                                            <div class="brand">sony</div>
                                                            <div class="excerpt">
                                                                <div class="star-holder">
                                                                    <div class="star" data-score="4"></div>
                                                                </div>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut lobortis euismod erat sit amet porta. Etiam venenatis ac diam ac tristique. Morbi accumsan consectetur odio ut tincidunt.</p>
                                                            </div>
                                                            <div class="addto-compare">
                                                                <a class="btn-add-to-compare" href="#">add to compare list</a>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.body-holder -->
                                                    <div class="no-margin col-xs-12 col-sm-3 price-area">
                                                        <div class="right-clmn">
                                                            <div class="price-current">$1199.00</div>
                                                            <div class="price-prev">$1399.00</div>
                                                            <div class="availability"><label>availability:</label><span class="not-available">out of stock</span></div>
                                                            <a class="le-button disabled" href="#">add to cart</a>
                                                            <a class="btn-add-to-wishlist" href="#">add to wishlist</a>
                                                        </div>
                                                    </div><!-- /.price-area -->
                                                </div><!-- /.row -->
                                            </div><!-- /.product-item -->


                                            <div class="product-item product-item-holder">
                                                <div class="ribbon red"><span>sell</span></div>
                                                <div class="row">
                                                    <div class="no-margin col-xs-12 col-sm-4 image-holder">
                                                        <div class="image">
                                                            <img alt="" src="assets/images/blank.gif" data-echo="assets/images/products/product-03.jpg" />
                                                        </div>
                                                    </div><!-- /.image-holder -->
                                                    <div class="no-margin col-xs-12 col-sm-5 body-holder">
                                                        <div class="body">
                                                            <div class="label-discount clear"></div>
                                                            <div class="title">
                                                                <a href="single-product.html">VAIO Fit Laptop - Windows 8 SVF14322CXW</a>
                                                            </div>
                                                            <div class="brand">sony</div>
                                                            <div class="excerpt">
                                                                <div class="star-holder">
                                                                    <div class="star" data-score="2"></div>
                                                                </div>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut lobortis euismod erat sit amet porta. Etiam venenatis ac diam ac tristique. Morbi accumsan consectetur odio ut tincidunt. </p>
                                                            </div>
                                                            <div class="addto-compare">
                                                                <a class="btn-add-to-compare" href="#">add to compare list</a>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.body-holder -->
                                                    <div class="no-margin col-xs-12 col-sm-3 price-area">
                                                        <div class="right-clmn">
                                                            <div class="price-current">$1199.00</div>
                                                            <div class="price-prev">$1399.00</div>
                                                            <div class="availability"><label>availability:</label><span class="available">in stock</span></div>
                                                            <a class="le-button" href="#">add to cart</a>
                                                            <a class="btn-add-to-wishlist" href="#">add to wishlist</a>
                                                        </div>
                                                    </div><!-- /.price-area -->
                                                </div><!-- /.row -->
                                            </div><!-- /.product-item -->

                                            <div class="product-item product-item-holder">
                                                <div class="row">
                                                    <div class="no-margin col-xs-12 col-sm-4 image-holder">
                                                        <div class="image">
                                                            <img alt="" src="assets/images/blank.gif" data-echo="assets/images/products/product-04.jpg" />
                                                        </div>
                                                    </div><!-- /.image-holder -->
                                                    <div class="no-margin col-xs-12 col-sm-5 body-holder">
                                                        <div class="body">
                                                            <div class="title">
                                                                <a href="single-product.html">VAIO Fit Laptop - Windows 8 SVF14322CXW</a>
                                                            </div>
                                                            <div class="brand">sony</div>
                                                            <div class="excerpt">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut lobortis euismod erat sit amet porta. Etiam venenatis ac diam ac tristique. Morbi accumsan consectetur odio ut tincidunt. </p>
                                                            </div>
                                                            <div class="addto-compare">
                                                                <a class="btn-add-to-compare" href="#">add to compare list</a>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.body-holder -->
                                                    <div class="no-margin col-xs-12 col-sm-3 price-area">
                                                        <div class="right-clmn">
                                                            <div class="price-current">$1199.00</div>
                                                            <div class="price-prev">$1399.00</div>
                                                            <div class="availability"><label>availability:</label><span class="available">  in stock</span></div>
                                                            <a class="le-button" href="#">add to cart</a>
                                                            <a class="btn-add-to-wishlist" href="#">add to wishlist</a>
                                                        </div>
                                                    </div><!-- /.price-area -->
                                                </div><!-- /.row -->
                                            </div><!-- /.product-item -->

                                            <div class="product-item product-item-holder">
                                                <div class="ribbon green"><span>bestseller</span></div>
                                                <div class="row">
                                                    <div class="no-margin col-xs-12 col-sm-4 image-holder">
                                                        <div class="image">
                                                            <img alt="" src="assets/images/blank.gif" data-echo="assets/images/products/product-05.jpg" />
                                                        </div>
                                                    </div><!-- /.image-holder -->
                                                    <div class="no-margin col-xs-12 col-sm-5 body-holder">
                                                        <div class="body">
                                                            <div class="label-discount clear"></div>
                                                            <div class="title">
                                                                <a href="single-product.html">VAIO Fit Laptop - Windows 8 SVF14322CXW</a>
                                                            </div>
                                                            <div class="brand">sony</div>
                                                            <div class="excerpt">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut lobortis euismod erat sit amet porta. Etiam venenatis ac diam ac tristique. Morbi accumsan consectetur odio ut tincidunt.</p>
                                                            </div>
                                                            <div class="addto-compare">
                                                                <a class="btn-add-to-compare" href="#">add to compare list</a>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.body-holder -->
                                                    <div class="no-margin col-xs-12 col-sm-3 price-area">
                                                        <div class="right-clmn">
                                                            <div class="price-current">$1199.00</div>
                                                            <div class="price-prev">$1399.00</div>
                                                            <div class="availability"><label>availability:</label><span class="available">  in stock</span></div>
                                                            <a class="le-button" href="#">add to cart</a>
                                                            <a class="btn-add-to-wishlist" href="#">add to wishlist</a>
                                                        </div>
                                                    </div><!-- /.price-area -->
                                                </div><!-- /.row -->
                                            </div><!-- /.product-item -->

                                        </div><!-- /.products-list -->

                                        <div class="pagination-holder">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6 text-left">
                                                    <ul class="pagination">
                                                        <li class="current"><a  href="#">1</a></li>
                                                        <li><a href="#">2</a></li>
                                                        <li><a href="#">3</a></li>
                                                        <li><a href="#">4</a></li>
                                                        <li><a href="#">next</a></li>
                                                    </ul><!-- /.pagination -->
                                                </div>
                                                <div class="col-xs-12 col-sm-6">
                                                    <div class="result-counter">
                                                        Showing <span>1-9</span> of <span>11</span> results
                                                    </div><!-- /.result-counter -->
                                                </div>
                                            </div><!-- /.row -->
                                        </div><!-- /.pagination-holder -->

                                    </div><!-- /.products-grid #list-view -->

                                </div><!-- /.tab-content -->
                            </div><!-- /.grid-list-products -->

                        </section><!-- /#gaming -->
                    </div><!-- /.col -->
                    <!-- ========================================= CONTENT : END ========================================= -->
                </div><!-- /.container -->
            </section><!-- /#category-grid -->

              </div><!-- /.wrapper -->

