<?php
   /* @var $this yii\web\View */
   
   $this->title = 'Detalle producto';
   
   use kartik\form\ActiveForm;
   use kartik\builder\Form;
   use yii\helpers\Html;
   use frontend\models\PreguntaProducto;
   use yii\bootstrap\Modal;
   use frontend\models\ReporteProducto;
   use yii\helpers\Url;
   use kartik\checkbox\CheckboxX;
   use kartik\widgets\StarRating;

   ?>
<div id="single-product">
   <div class="container">
      <div class="no-margin col-xs-12 col-sm-6 col-md-5 gallery-holder">
         <div class="product-item-holder size-big single-product-gallery small-gallery">
            <div id="owl-single-product" class="owl-carousel">
               <div class="single-product-gallery-item" id="slide1">
                  <a data-rel="prettyphoto" href="<?php echo Yii::$app->request->baseUrl . '/imagenes/productos/' . $producto->imagenPrincipalProductos->nombre_archivo ?>">
                  <img class="img-responsive" alt="" src="<?php echo Yii::$app->request->baseUrl;?>/img/core-img/blank.gif" data-echo="<?php echo Yii::$app->request->baseUrl . '/imagenes/productos/' . $producto->imagenPrincipalProductos->nombre_archivo ?>" />
                  </a>
               </div>
               <!-- /.single-product-gallery-item -->
               <?php foreach ($producto->imagenProductoSecundarias as $index => $imagen): ?>
               <div class="single-product-gallery-item" id="slide<?php echo $index+2;?>">
                  <a data-rel="prettyphoto" href="<?php echo Yii::$app->request->baseUrl . '/imagenes/productos/' . $imagen->nombre_archivo ?>">
                  <img class="img-responsive" alt="" src="<?php echo Yii::$app->request->baseUrl;?>/img/core-img/blank.gif" data-echo="<?php echo Yii::$app->request->baseUrl . '/imagenes/productos/' . $imagen->nombre_archivo ?>" />
                  </a>
               </div>
               <?php endforeach; ?>
            </div>
            <!-- /.single-product-slider -->
            <div class="single-product-gallery-thumbs gallery-thumbs">
               <div id="owl-single-product-thumbnails" class="owl-carousel">
                  <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="0" href="#slide1">
                  <img width="67" alt="" src="<?php echo Yii::$app->request->baseUrl;?>/img/core-img/blank.gif" data-echo="<?php echo Yii::$app->request->baseUrl . '/imagenes/productos/' . $producto->imagenPrincipalProductos->nombre_archivo ?>" />
                  </a>
                  <?php foreach ($producto->imagenProductoSecundarias as $index => $imagen): ?>    
                  <a class="horizontal-thumb" data-target="#owl-single-product" data-slide="<?php echo $index+1;?>" href="#slide<?php echo $index+2;?>">
                  <img width="67" alt="" src="<?php echo Yii::$app->request->baseUrl;?>/img/core-img/blank.gif" data-echo="<?php echo Yii::$app->request->baseUrl . '/imagenes/productos/' . $imagen->nombre_archivo ?>" />
                  </a>
                  <?php endforeach; ?>
               </div>
               <!-- /#owl-single-product-thumbnails -->
               <div class="nav-holder left hidden-xs">
                  <a class="prev-btn slider-prev" data-target="#owl-single-product-thumbnails" href="#prev"></a>
               </div>
               <!-- /.nav-holder -->
               <div class="nav-holder right hidden-xs">
                  <a class="next-btn slider-next" data-target="#owl-single-product-thumbnails" href="#next"></a>
               </div>
               <!-- /.nav-holder -->
            </div>
            <!-- /.gallery-thumbs -->
         </div>
      </div>



      <!-- /.gallery-holder -->
      <?=
         Html::beginForm(Yii::$app->urlManager->createUrl([
                     'producto/agregar-carrito',]), '', ['class' => 'form-horizontal cart clearfix mb-50 d-flex']);
         ?>
      <div class="no-margin col-xs-12 col-sm-7 body-holder">
         <div class="body">
            <div class="star-holder inline">
               <div class="star" data-score="<?= (int)$prom_cal; ?>" ></div>
            </div>
            <div class="availability"><label>Estado: </label><span class="available"> <?= $producto->estadoProducto->descripcion ?></span></div>
            <div class="title"><a href="#"><?= $producto->nombre ?></a></div>
            <div class="label-discount green"><a target="_blank" href="<?=Url::to(['producto/lista-jagao', 'proveedor' => $producto->proveedor->nombre ])?>"><?= $producto->proveedor->nombre; ?></a></div>
          
            <div class="buttons-holder">
             <!--  <a class="btn-add-to-wishlist" href="#">add to wishlist</a>
               <a class="btn-add-to-compare" href="#">add to compare list</a>-->
            </div>
            <div class="excerpt">
               <p><?= $producto->descripcion ?></p>
            </div>
            <div class="talla_grid form-inline" >
               <div >
                  <label>
                  Talla - Color   </label>
                  <select class="form-control" name="talla-color" id="select-tall-color" style="wid">
                     <?php foreach ($producto->productoTallas as $talla): ?>
                     <option value="<?= $talla->id ?>" codigo-color="<?=$talla->codigo_color?>">
                        <?= $talla->talla->descripcion . ' - ' . $talla->codigo_color ?>
                     </option>
                     <?php endforeach; ?>
                  </select>
                  <i id="icono-color"  class="fa fa-circle " aria-hidden="true" style="color:<?= ($producto->productoTallas[0]->codigo_color == 'No Aplica' ? 'transparent' : $producto->productoTallas[0]->codigo_color)?>;"></i>
               </div>
            </div>
            <br>
            <div class="prices">
            
               <div class="price-current">COP: <?= '$' . number_format($producto->precio_pesos, 2, ',', '.') ?></div>
               <?php if(!empty($producto->cantidad_gratis_envio)):  ?>
                <p>Envío gratis a partir de <?= $producto->cantidad_gratis_envio; ?> unidades.</p>
               <?php endif;?>

               
               <?php if(!empty($producto->productoDescuentos->descuento)):  ?>
               <div class="price-prev"><?= 'COP $'.number_format( ($producto->precio_pesos*100)/(100-$producto->productoDescuentos->descuento),2,',', '.');  ?></div>
            <?php endif;?>
               
         

            </div>
            <input type="hidden" name="id-producto" value="<?= $producto->id ?>">
            <div class="qnt-holder">
               <div class="le-quantity">
                  <form>
                     <a class="minus not_detail" href="#reduce"></a>
                     <input name="quantity" readonly="readonly" type="text" value="1" />
                     <a class="plus" href="#add"></a>
                  </form>
               </div>
               <button class="le-button huge btn-add-cart" id="addto-cart">Añadir al carrito</button><br><br>
             
               <?=
                    Html::beginForm(Yii::$app->urlManager->createUrl([
                                'producto/agregar-carrito',]), '', ['class' => 'form-horizontal cart clearfix mb-50 d-flex']);
                    ?>

                    <?= Html::endForm(); ?>
                    <p>
                    ¿Crees que este producto no debería estar en venta? <a href=""  data-toggle="modal" data-target="#w0">Cuéntanos por qué</a>.
                        <?php
                        Modal::begin([
                            'headerOptions' => [
                                'style' => 'background-color:#60c011;z-index: 9999;',
                               
                            ],
                            'bodyOptions' => [
                                'style' => 'z-index: 9999;'
                            ],
                            
                        ]);
                        echo $this->render('//reporte-producto/_form', ['model' => new ReporteProducto(), 'idProducto' => $producto->id]);
                        Modal::end();
                        ?>
                    </p>
            </div>
            <!-- /.qnt-holder -->
         </div>
         <!-- /.body -->
      </div>
      <!-- /.body-holder -->
      <?= Html::endForm(); ?>
   </div>
   <!-- /.container -->
</div>
<!-- /.single-product -->
<!-- ========================================= SINGLE PRODUCT TAB ========================================= -->
<section id="single-product-tab">
   <div class="container">
   <div class="tab-holder">
      <ul class="nav nav-tabs simple" >
         <li class="active"><a href="#description" data-toggle="tab">Descripción</a></li>
         <li><a href="#additional-info" data-toggle="tab">Comentarios</a></li>
         <li><a href="#reviews" data-toggle="tab">Preguntas (<?= count($producto->preguntaProductos) ?>)</a></li>
      </ul>
      <!-- /.nav-tabs -->
      <div class="tab-content">
         <div class="tab-pane active" id="description">
            <p><?= $producto->descripcion ?></p>
            <div class="meta-row">
               <div class="inline">
                  <label>SKU:</label>
                  <span>54687621</span>
               </div>
               <!-- /.inline -->
               <span class="seperator">/</span>
               <div class="inline">
                  <label>Categorías:</label>
                  <?php  foreach ($producto->subcategoria as $index => $categoria):  
                     $categorias[] = '<span> <a href="#">'.ucfirst($categoria->nombre).'</a></span>'; ?>
                  <?php endforeach;
                     echo  implode( ', ', $categorias ?? array() );
                     ?>
               </div>
               <!-- /.inline -->
               <span class="seperator">/</span>
               <div class="inline">
                  <label>tag:</label>
                  <?php  foreach ($producto->tag as $index => $tag):  
                     $tags[] = '<span> <a href="#">'.ucfirst($tag->descripcion).'</a></span>'; ?>
                  <?php endforeach;
                     echo implode( ', ', $tags );
                     ?>
               </div>
               <!-- /.inline -->
            </div>
            <!-- /.meta-row -->
         </div>
         <!-- /.tab-pane #description -->
         <div class="tab-pane" id="additional-info">
            <ul class="tabled-data">
            <div class="comments">
               <div style="overflow: auto;">
                  <?php if (empty($producto->productoCalificacion)) { ?>
                  <h4>Este producto aún no tiene comentarios.</h4>
                  <?php } else { ?>
                  <?php foreach ($producto->productoCalificacion as $calificacion): ?>
                  <div class="comment-item">
                     <div class="row no-margin">
                        <div class="col-xs-12 col-lg-11 col-sm-10 no-margin">
                           <div class="comment-body">
                              <div class="meta-info">
                                 <div class="author inline">
                                    <a href="#" class="bold"><?= $producto->userCalificacion->name.' '.$producto->userCalificacion->surname; ?></a>
                                    <div class="star-holder inline">
                                       <div class="star" data-score=" <?= $calificacion->calificacion ?>" ></div>
                                    </div>
                                 </div>
                                 <div class="date inline pull-right">
                                    <?= $calificacion->creado_el ?>
                                 </div>
                              </div>
                              <p class="comment-text">
                                 <?= $calificacion->descripcion ?>                                                          
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
                 
                  <hr>
                  <?php endforeach; ?>
                  <?php } ?>
               </div>
            </div>
            
            </ul>
            <!-- /.tabled-data -->
            <div class="meta-row">
               <div class="inline">
                  <label>SKU:</label>
                  <span>54687621</span>
               </div>
               <!-- /.inline -->
               <span class="seperator">/</span>
               <div class="inline">
                  <label>Categorías:</label>
                  <?php
                     echo  implode( ', ', $categorias ?? array() );
                     ?>
               </div>
               <!-- /.inline -->
               <span class="seperator">/</span>
               <div class="inline">
                  <label>tag:</label>
                  <?php 
                     echo implode( ', ', $tags );
                     ?>
               </div>
            </div>
            <!-- /.meta-row -->
         </div>
         <!-- /.tab-pane #additional-info -->
         <div class="tab-pane" id="reviews">
            <div class="comments">
              
                  <?php if (empty($producto->preguntaProductos)) { ?>
                  <h4>¡Ups! Este producto aún no cuenta con preguntas, sé el primero. </h4>
                  <?php } else { ?>
                  <div class="col-sm-12" style="overflow: auto;">                     
                  <?php foreach ($producto->preguntaProductos as $pregunta): ?>
                  <div class="comment-item">
                     <div class="row no-margin">
                        <div class="col-xs-12 col-lg-11 col-sm-10 no-margin">
                           <div class="comment-body">
                              <div class="meta-info">
                                 <div class="author inline">
                                    <a href="#" class="bold"><?= $producto->userPregunta->name.' '.$producto->userPregunta->surname; ?></a>
                                 </div>
                                 <div class="date inline pull-right">
                                    <?= $pregunta->creado_el ?>
                                 </div>
                              </div>
                              <p class="comment-text">
                                 <?= $pregunta->descripcion ?>                                                          
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php if (!empty($pregunta->respuestaProducto)) : ?>
                  <p><strong>Respuesta del vendedor: </strong><?= $pregunta->respuestaProducto->descripcion ?></p>
                  <div class="text-right" style="font-size: 12px;">
                     <strong>Fecha de respuesta: </strong><?= $pregunta->respuestaProducto->creado_el ?>
                  </div>
                  <?php endif; ?>
                  <hr>
                  <?php endforeach; ?>
                  <?php } ?>
               </div>
               <!--
                  <div class="comment-item">
                          <div class="row no-margin">
                              <div class="col-lg-1 col-xs-12 col-sm-2 no-margin">
                                  <div class="avatar">
                                      <img alt="avatar" src="assets/images/default-avatar.jpg">
                                  </div>
                              </div>
                  
                              <div class="col-xs-12 col-lg-11 col-sm-10 no-margin">
                                  <div class="comment-body">
                                      <div class="meta-info">
                                          <div class="author inline">
                                              <a href="#" class="bold">John Smith</a>
                                          </div>
                                          <div class="star-holder inline">
                                              <div class="star" data-score="4"></div>
                                          </div>
                                          <div class="date inline pull-right">
                                              12.07.2013
                                          </div>
                                      </div>
                                      <p class="comment-text">
                                          Integer id purus ultricies nunc tincidunt congue vitae nec felis. Vivamus sit amet nisl convallis, faucibus risus in, suscipit sapien. Vestibulum egestas interdum tellus id venenatis.
                                      </p>
                                  </div>
                  
                              </div>/.col 
                  
                          </div>
                      </div> /.comment-item -->
               <div class="add-review row">
                  <div class="col-sm-12 col-xs-12">
                     <div class="new-review-form">
                        <h2>Nueva Pregunta</h2>
                        <?php if (Yii::$app->user->isGuest) { ?>
                        <div class="alert alert-warning">
                           <p>
                              Para realizar una pregunta es necesario que tengas una cuenta JAGAO.CO, si la tienes
                              ingresa dando click <a target="_blank" href="<?= Url::to(['site/login']) ?>">aquí</a>,
                              de lo contrario puedes crear una cuenta dando clic en  <a target="_blank" href="<?= Url::to(['site/signup']) ?>">registrar</a>.
                           </p>
                        </div>
                        <?php
                           } else {
                               $modelPregunta = new PreguntaProducto();
                               $form = ActiveForm::begin([
                                           'type' => ActiveForm::TYPE_VERTICAL,
                                           'action' => Yii::$app->urlManager->createUrl([
                                               'pregunta-producto/create']),
                                           'method' => 'POST',
                               ]);
                               echo Form::widget([
                                   'model' => $modelPregunta,
                                   'form' => $form,
                                   'attributes' => [
                                       'descripcion' => [
                                           'label' => '<strong>¿Cuál es tu pregunta?</strong>',
                                           'type' => Form::INPUT_TEXTAREA,
                                           'options' => [
                                               'required' => true
                                           ],
                                           'hint' => '<span style="font-size: 1rem; margin-top: .375rem; color: #999;" class="help-block">Evita pedir direcciones, numeros de teléfono o información que afecte el funcionamiento de la plataforma, ese tipo de preguntas o respuestas serán eliminadas de la publicación.</span>'
                                       ],
                                       'producto_id' => [
                                           'type' => Form::INPUT_HIDDEN,
                                           'options' => [
                                               'value' => $producto->id,
                                               'class' => "le-input"
                                           ]
                                       ],
                                       'estado_pregunta_id' => [
                                           'type' => Form::INPUT_HIDDEN,
                                           'options' => [
                                               'value' => 1
                                           ]
                                       ],
                                   ]
                               ]);
                               ?>
                        <div class="text-right">
                           <button type="submit" class="le-button huge">Enviar</button>
                        </div>
                        <?php
                           ActiveForm::end();
                           }
                           ?>
                        <!--<form id="contact-form" class="contact-form" method="post" >
                           <div class="row field-row">
                               <div class="col-xs-12 col-sm-6">
                                   <label>name*</label>
                                   <input class="le-input" >
                               </div>
                               <div class="col-xs-12 col-sm-6">
                                   <label>email*</label>
                                   <input class="le-input" >
                               </div>
                           </div>
                           
                           <div class="field-row star-row">
                               <label>your rating</label>
                               <div class="star-holder">
                                   <div class="star big" data-score="0"></div>
                               </div>
                           </div>
                           
                           <div class="field-row">
                               <label>your review</label>
                               <textarea rows="8" class="le-input"></textarea>
                           </div>
                           
                           <div class="buttons-holder">
                               <button type="submit" class="le-button huge">submit</button>
                           </div> /.buttons-holder 
                           </form> -->
                     </div>
                     <!-- /.new-review-form -->
                  </div>
                  <!-- /.col -->
               </div>
               <!-- /.add-review -->
            </div>
            <!-- /.tab-pane #reviews -->
         </div>
         <!-- /.tab-content -->
      </div>
      <!-- /.tab-holder -->
   </div>
   <!-- /.container -->
</section>
<!-- /#single-product-tab -->
<!-- ========================================= RECENTLY VIEWED : END ========================================= -->
<!-- ============================================================= FOOTER ============================================================= -->