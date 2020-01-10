<?php

namespace frontend\controllers;

use backend\models\AuthAssignment;
use Yii;
use frontend\models\Producto;
use frontend\models\ProductoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use frontend\models\ImagenProductoSecundaria;
use frontend\models\ImagenPrincipalProducto;
use frontend\models\Proveedor;
use frontend\models\ProductoCalificacion;
use frontend\models\ProductoCompras;
use yii\helpers\Html;
use yii\data\Pagination;
use common\models\User;
use frontend\models\ProductoTalla;
use yii\helpers\Url;
use yii\rest\ActiveController;


/**
 * ProductoController implements the CRUD actions for Producto model.
 */
class ProductoController extends Controller
{

    const ERROR_CANTIDAD        = 'La cantidad elegida supera el stock de este producto. Por favor elige una cantidad menor.';
    const ERROR_CANTIDAD_STOCK  = 'La cantidad elegida supera el stock de este producto. Por favor intenta elegir una cantidad menor o un talla/color diferente.';
    const ERROR                 = 'Ocurrió un error inesperado. Por favor, contacte con nuestro administrador.';

    public $layout = 'main-admin';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Producto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Inactiva un producto
     * @param integer $id
     * @return mixed
     */
    public function actionInactivar($id) {      
        $this->switchingStatus($id,'5');
    }

    /**
     * Activa un producto
     * @param integer $id
     * @return mixed
     */
    public function actionActivar($id) {
       $let = $this->switchingStatus($id,'1');
       if(!$let)
        return $this->render('//site/error', [
            'name' => 'Permiso Denegado',
            'message' => 'Este producto fue inactivado por el administrador. Por favor solicitar su activación.',
        ]);
    }

    /**
     * Cambia los estados de un producto
     * @param integer id
     * @param String $status_prov Estado del proveedor a cambiar
     * @param String $status_prod Estado del producto a cambiar
     * @param String $old_state Búsqueda del estado del producto actual
     * @return View Index
     */
    protected function switchingStatus($id,$new_status){
        $product  = $this->findModel($id);
        $get_auth = AuthAssignment::find()->where(['user_id'=>$product->actualizado_por,'item_name'=>'r-admin'])->one();
        if($product->estado_producto_id=='5' and !empty($get_auth) and !Yii::$app->user->can('r-super-admin') and !Yii::$app->user->can('r-administrador-jagao')){
            return false;
        }
        $product->estado_producto_id= $new_status;
        $product->save();
        return $this->redirect(['index']); 
    }

    /**
     * Validar usuario si está logueado
     */
    public function actionValidateUser(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $message = [];
        if (empty(Yii::$app->user->id))
         $message =['error'=>true, 'message'=>'Para continuar tu compra por favor <a href="'.Url::to(['site/login']).'">inicia sesión</a>. Si no tienes una cuenta puedes crear una dando clic en <a href="'.Url::to(['site/signup']).'">regístrate</a>.'];

        return $message;
    }

    /**
     * Método que busca los productos según el valor a encontrar.
     * @author Michael Rosero 
     */
    public function actionListaJagao($query_txt = NULL, $proveedor = NULL)
    {
        $this->layout = 'main';

        $query      = Producto::find()->where(['=', 'estado_producto_id', 1]);

        if (!empty($query_txt))
            $query  = $query->andWhere(['like', 'nombre', '%' . $query_txt . '%', false]);

        if (!empty($proveedor)) {
            $get_id_prov = Proveedor::find()->where(['=', 'nombre', $proveedor])->one();
            if (!empty($get_id_prov))
                $query  = $query->andWhere(['=', 'proveedor_id', $get_id_prov->id]);
        }

        /** Paginador */
        $pages      = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => 20]);
        $producto_categoria    = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render(
            'producto_list',
            [
                'producto_categoria' => $producto_categoria,
                'pagination' => $pages
            ]
        );
    }

    /**
     * Displays a single Producto model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $imagenPrincipal = $model->imagenPrincipalProductos;
        $imagenesSegundarias = $model->imagenProductoSecundarias;
        $subcategorias = $model->productoSubcategorias;
        $tags = $model->tags;
        $imagenProveedor = $model->proveedor->imagenProveedors;
        return $this->render('view', [
            'model' => $model,
            'imagenPrincipal' => $imagenPrincipal,
            'imagenesSegundarias' => $imagenesSegundarias,
            'subcategorias' => $subcategorias,
            'tags' => $tags,
            'imagenProveedor' => $imagenProveedor,
        ]);
    }

    /**
     * Creates a new Producto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('r-proveedor')){
            $model = new Producto();
            if (!empty(Yii::$app->request->post())) {
                if ($model->load(Yii::$app->request->post())) {
                    $proveedor = \frontend\models\Proveedor::find()->where(['usuario_id' => Yii::$app->user->id])->one();
                    $model->proveedor_id = $proveedor->id;
                    if (!$model->save()) {
                        print_r($model->getErrors());
                        die();
                    }
                    $model->asociarTallas(Yii::$app->request->post()['Producto']['producto_tallas']);
                    if ($model->cantidad_stock > 0) {
                        $model->estado_producto_id = 1;
                    } else {
                        $model->estado_producto_id = 2;
                    }
                    
                    $model->save();
                    /**
                     * Asocia los tags o palabras claves
                     */
                    $model->asociarTags(Yii::$app->request->post()['Producto']['tags']);
                    /**
                     * Asocia las categorias
                     */
                    // $model->asociarCategorias(Yii::$app->request->post()['Producto']['categorias']);
                    $model->asociarSubcategorias(Yii::$app->request->post()['Producto']['subcategorias']);
    
                    /**
                     * Almaceno la imagen principal
                     */
                    $model->almacenarImagenPrincipal();
                    /**
                     * Se realiza primero la carga de los archivos hacia el atributo
                     * del modelo y luego en el modelo se realiza el guardado y la
                     * creación de los objetos que tienen la información de cada 
                     * imagen
                     */
                    $model->imagenes_segundarias = UploadedFile::getInstances($model, 'imagenes_segundarias');
                    $model->almacenarImagenesSegundarias();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
    
    
            return $this->render('create', [
                'model' => $model,
            ]);
        }


    }

    /**
     * Updates an existing Producto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('r-proveedor')){            
            $model = $this->findModel($id);

            if($model->estado_producto_id == '4' or $model->estado_producto_id == '5'){
                return $this->render('//site/error', [
                    'name' => 'Permiso Denegado',
                    'message' => 'Este producto se encuentra inactivado. Por favor, solicite su activación.',
                ]);
            }
            if(self::validateProvProducto($id)){
                return $this->render('//site/error', [
                    'name' => 'Permiso Denegado',
                    'message' => 'Acceso denegado. No puede modificar este producto.',
                ]);
            }


            $imagenPrincipal = $model->imagenPrincipalProductos;
            $imagenesSegundarias = $model->imagenProductoSecundarias;
            if ($model->load(Yii::$app->request->post())) {

                if (!$model->save()) {
                    print_r($model->getErrors());
                    die();
                }
                $model->asociarTallas(Yii::$app->request->post()['Producto']['producto_tallas']);
                if ($model->cantidad_stock > 0 && $model->estado_producto_id != 3) {
                    $model->estado_producto_id = 1;
                } elseif ($model->estado_producto_id != 3) {
                    $model->estado_producto_id = 2;
                }
                $model->save();
                /**
                 * Asocia los tags o palabras claves
                 */
                $model->asociarTags(Yii::$app->request->post()['Producto']['tags']);
                /**
                 * Asocia las categorias
                 */
                $model->asociarSubcategorias(Yii::$app->request->post()['Producto']['subcategorias']);

                if (!empty($_FILES)) {
                    /**
                     * Almaceno la imagen principal
                     */
                    $archivo = UploadedFile::getInstance($model, 'imagen_principal');
                    if (!empty($archivo)) {
                        $imagenPrincipalActual = ImagenPrincipalProducto::find()->where(['producto_id' => $model->id])->one();
                        unlink($imagenPrincipalActual->ruta_archivo);
                        $imagenPrincipalActual->delete();
                        $model->almacenarImagenPrincipal();
                    }
                    /**
                     * Se realiza primero la carga de los archivos hacia el atributo
                     * del modelo y luego en el modelo se realiza el guardado y la
                     * creación de los objetos que tienen la información de cada 
                     * imagen
                     */
                    $model->imagenes_segundarias = UploadedFile::getInstances($model, 'imagenes_segundarias');
                    $model->almacenarImagenesSegundarias();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
                'imagenPrincipal' => $imagenPrincipal,
                'imagenesSegundarias' => $imagenesSegundarias,
            ]);
        }else{
            return $this->render('//site/error', [
                'name' => 'Permiso Denegado',
                'message' => 'No tiene los permisos suficientes para ingresar a esta página',
            ]);
        }
    }

    /**
     * Valida si un producto pertenece a un proveedor
     */
    protected static function validateProvProducto($producto_id){
        $get_person = Producto::find()->where(['proveedor_id'=>@Proveedor::find()->where(['usuario_id' => Yii::$app->user->id])->one()->id,'id'=>$producto_id])->all();
        return empty($get_person);
    }
    /**
     * Deletes an existing Producto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
      //  $this->findModel($id)->delete();

       // return $this->redirect(['index']);
    }

    /**
     * Finds the Producto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Producto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Producto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Elimina la imagen segundaria seleccionada
     * @param type $idImagen
     * @return boolean
     */
    public function actionEliminarImagenSegundaria($idImagen)
    {
        $imagen = ImagenProductoSecundaria::findOne($idImagen);
        /**
         * Así se realiza la eliminación de un archivo
         */
        unlink($imagen->ruta_archivo);
        if (!$imagen->delete()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Lista los productos que se han añadido al carrito
     * @author Michael Rosero Salazar - michael9707
     */
    public function actionListCart()
    {
        $this->layout = 'main';
        $cart       = Yii::$app->cart;
        $list_cart  = $cart->getItemIds();
        return $this->render('cart_list', [
            'list_cart' => $list_cart
        ]);
    }
    /**
     * Obtiene el total del coste de envío
     * 
     */
    public static function totalShipping()
    {
        try {
            $total_shipping = NULL;
            $cart           = Yii::$app->cart;
            $products       = self::getPropertiesProductCar($cart);
            if (!empty($products)) {
                $total_shipping = array_sum(array_column($products, 'shipping'));
                return empty($total_shipping) ? 0 : $total_shipping;
            }else{
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Método que muestra los productos añadidos en el carrito.
     * @author Michael Rosero - michael9707
     */
    public function actionMostrarCarrito()
    {
        $item      = array();
        $cart      = Yii::$app->cart;
        $list_cart = $cart->getItemIds();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        foreach ($list_cart as $key => $id) {
            $setting = $cart->getItem($id);
            $item[$key]["nombre"]         = $setting->getProduct()->producto->nombre;
            $item[$key]["color"]          = $setting->getProduct()->codigo_color;
            $item[$key]["talla"]          = $setting->getProduct()->talla->descripcion;
            $item[$key]["cantidad_stock"] = $setting->getQuantity();
            $item[$key]["precio_pesos"]   = $this->formatoPrecio($setting->getProduct()->producto->precio_pesos);
            $item[$key]["descripcion"]    = Yii::$app->request->baseUrl . '/imagenes/productos/' . $setting->getProduct()->producto->imagenPrincipalProductos->nombre_archivo;
        }
        return @$item;
    }

    /**
     * Cambiar cantidad y productos en el carrito de compras
     * @author: Michael Rosero - michael9707
     */
    public function actionCambiarCarrito()
    {
        $get_products = Yii::$app->request->post("id-producto");
        $get_quantity = Yii::$app->request->post("quantity");
        $cart         = Yii::$app->cart;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        foreach ($get_products as $key => $product) {

            $product    = ProductoTalla::findOne($product);//Producto::findOne($product);
            $cantidad   = $get_quantity[$key];

            $validate_c = $this->validateStockProduct($product, $cantidad);
            if ($validate_c['error'] === true) return array('error' => array("id"=>$product->id,"text"=> $validate_c['message']));

            $cart->change($product->id, $cantidad);
        }
        $propProduc = $this->getPropertiesProductCar($cart);
        $total_ship = $this->totalShipping();
        $real_total = $total_ship + $this->getTotalCost($cart);
        $precio_tot = $this->getTotalCost($cart);

        
        return  array("prop" => $propProduc,"total"=>$this->formatoPrecio($real_total), "subtotal" => $this->formatoPrecio($precio_tot),"envio"=>$this->formatoPrecio($total_ship));
    }

    /**
     * Método que obtiene las propiedades de un objeto de tipo carrito
     * @author: Michael Rosero - michael9707
     */
    public static function getPropertiesProductCar($cart = array())
    {
        foreach ($cart->getItemIds() as $key => $product) {

            $item               = Yii::$app->cart->getItem($product);
            $product_det        = $item->getProduct();
            $get_cost_product   = ($product_det->producto->precio_pesos) * $item->getQuantity();
            $prod[$key]['key']  = md5($product_det->id);
            $prod[$key]['cost'] = self::formatoPrecio($get_cost_product);
            $quantity_arr       = $item->getQuantity();            
            $prod[$key]['cost_w']= $get_cost_product;
            $prod[$key]['shipping'] = self::getShipping($product_det,$quantity_arr);
        }
        return @$prod;
    }
    /**
     * Obtengo el valor de envío de un producto
     * @param Producto $producto_det 
     * @param integer  $quantity Cantidad del producto a registrar
     * @return integer Valor del envío de un producto
     */
    protected static function getShipping($product_det,$quantity){
        $shipping = 0;
        if ((int) $product_det->producto->aplica_envio == 1) {
            $adding_shiping     =  $product_det->producto->precio_envio_adicional;
            $limit_shipping     =  $product_det->producto->cantidad_gratis_envio;
            $shipping_init      =  $product_det->producto->precio_envio;
            $shipping          += (int) $shipping_init;
            
            if ($quantity < $limit_shipping)
                for ($i = 2; $i <= $quantity; $i++) $shipping   += (int) $adding_shiping;                
            else
                $shipping  = 0;
            
            return ($shipping > 0) ? $shipping : 0;
        }else{
            return 0;
        }
    }
    /**
     * Formatea un valor integer a formato pesos
     * @param integer $precio Cantidad o valor a transformar
     * @return Double Valor transformado a pesos
     */
    protected static function formatoPrecio($precio){
       return  number_format($precio, 0, ',', '.');
    }

    /**
     * Añade un producto al carrito de compra
     * @param type $idProducto
     * @param type $cantidad
     * @author Michael Rosero
     * @return Json Retorna la cantidad y el total del costo del carrito por Producto
     */
    public function actionAgregarCarrito()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request    = Yii::$app->request;
        $cantidad   = $request->post("quantity");

        $product    = ProductoTalla::findOne($request->post('talla-color'));

        $cart       = Yii::$app->cart;
        $item       = $cart->getItem($product->id);
        $count_cart = !empty($item) ?  $item->getQuantity() : 0;

        $validate_c = $this->validateStockProduct($product, ($cantidad + $count_cart));
        if ($validate_c['error'] === true) return array('error' => $validate_c['message']);

        $cart->add($product, $cantidad);
        $totalCost = $this->getTotalCost($cart);

        return array("count" => $cart->getTotalCount(), "tot" => $this->formatoPrecio($totalCost));
    }

    /**
     * Obtiene el costo total del carrito de compra
     * @param Cart $cart
     * @return integer del valor total de la compra
     */
    public static function getTotalCost($cart){
        $propProduc = self::getPropertiesProductCar($cart);
        if(!empty($propProduc)){
            $total      = array_sum(array_column($propProduc, 'cost_w'));
            return $total > 0 ? $total : 0;
        }
        return 0;
    }
    
    /**
     * Registra una nueva compra
     * @return mixed[] Arreglo con la información necesaria para la pasarela de pagos Epayco
     * @author Michael Rosero
     */
    public function actionRegistrarCompra($id_info)
    {
        $cart      = Yii::$app->cart;
        $list_cart = $cart->getItemIds();
        
        
        $total_compr    = ProductoCompras::find()->where(['user_id' => Yii::$app->user->id])->count() + 1;
        $factura        = uniqid(Yii::$app->user->id * $total_compr);
       
        foreach ($list_cart as $key => $id) {
            $setting    = $cart->getItem($id);
            $cantidad   = $setting->getQuantity();
            $get_product= $setting->getProduct();

            /** Validaciones */
            $validate_c = self::validateStockProduct($get_product, ($cantidad));
            if ($validate_c['error'] === true) return array('error' => $validate_c['message']);

            /** Almaceno el registro de la compra */
            $compra_producto                 = new ProductoCompras();
            $compra_producto->id_info_compra = $id_info;
            $compra_producto->producto_id_talla    = intval($setting->getProduct()->id);
            $compra_producto->producto_id    = intval($setting->getProduct()->producto->id);
            $compra_producto->estado_id      = 3; //Estado Pendiente
            $compra_producto->user_id        = Yii::$app->user->id;
            $compra_producto->descripcion    = $setting->getProduct()->producto->nombre;
            $compra_producto->cantidad       = $setting->getQuantity();
            $compra_producto->pago_proveedor = 0;
            $compra_producto->precio_costo   = $setting->getQuantity() * $setting->getProduct()->producto->precio_pesos;
            $compra_producto->costo_envio    = self::getShipping($get_product,$compra_producto->cantidad);
            $compra_producto->precio_total   = $compra_producto->precio_costo + $compra_producto->costo_envio;
            $compra_producto->codigo_factura = $factura;
            
            if (!$compra_producto->save()) {
                foreach ($compra_producto->getErrors() as $errores)  return array('error' => $errores);
            }
        }

        $calling_cart['info'] = self::getInfoBuy($cart,$factura);
        $cart->clear();
        return $calling_cart;

    }
    /**
     * Obtiene los parámetros para comprar en epayco
     */
    protected static function getInfoBuy($cart,$factura){
        $calling_cart = array(
            'name'       => 'Compra JAGAO',
            'description'=> 'Compra JAGAO',
            'invoice'    => $factura,
            'currency'   => "cop",
            'amount'     => self::getTotalCost($cart)+ self::totalShipping(),
            'tax_base'   => "0",
            'tax'        => "0",
            'country'    => "co",
            'lang'       => "en",
            'external'   => "true",
            'confirmation'=>Yii::$app->params['confirmation'],
            'response'    =>Yii::$app->params['response'],
            'name_billing'=>@Yii::$app->user->identity->username,
            );
        return $calling_cart;
    }
    /**
     * Método para desplegar el botón de Comprar PAGOS DIVIDIOS
     * @deprecated 
     * @author Michael Rosero
     */
    public function actionBuy()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $total_compr = ProductoCompras::find()->where(['user_id' => Yii::$app->user->id])->count() + 1;

        $cart       = Yii::$app->cart;
        //$pagos_div  = $this->dividePagos($cart);
        $totalCount = $cart->getTotalCount();
        $totalCost  = $this->getTotalCost($cart);
        $factura    = uniqid(Yii::$app->user->id * $total_compr);
        $id_main    = '32978';
        $iva        = '0';
        $p_key      = '50c4f3e57a484c4a4d076394c368136915e0c99c';
        $p_currency_code = 'COP';
        $p_split_type = '02';
        $percent    = '20'; // A Definir

        $p_signature        = md5($id_main . '^' . $p_key . '^' . $factura . '^' . $totalCost . '^' . $p_currency_code);
        $p_signature_split  = md5($p_split_type . '^' . $id_main . '^' . $id_main . '^' . $percent . '^' . $pagos_div['sign']);

        $buy['normal'] = array(
            'p_cust_id_cliente' => $id_main,
            'p_key' => $p_key,
            'p_id_invoice' => $factura,
            'p_description' => 'Compra JAGAO',
            'p_amount' => $totalCost,
            'p_amount_base' => $totalCost,
            'p_tax' => $iva,
            'p_email' => @Yii::$app->user->identity->email,
            'p_currency_code' => 'COP',
            'p_signature' => $p_signature,
            'p_test_request' => 'TRUE',
            'p_split_type' => $p_split_type,
            'p_split_merchant_receiver' => $id_main,
            'p_split_primary_receiver' => $id_main,
            'p_split_primary_receiver_fee' => $percent,
            'p_signature_split' => $p_signature_split
        );
        //$buy['dividido'] = $pagos_div['pagos'];
        return $buy;
    }
    /**
     * Divide los pagos de los productos
     * @author Michael Rosero
     * @param Cart $cart 
     */
    protected function dividePagos($cart)
    {
        $products    = $cart->getItemIds();
        $sign        = NULL;
        foreach ($products as $key => $prod) {
            $item    = $cart->getItem($prod);
            $cost    = $item->getCost();
            $product = $item->getProduct();
            $proveed = $product->proveedor->codigo_epayco;
            $pago_dividido['pagos'][] = array('id' => $proveed, 'fee' => $cost);
            $sign   .= $proveed . '^' . $cost;
        }
        $pago_dividido['sign']  = $sign;
        return $pago_dividido;
    }

    /**
     * Valida el stock de un producto
     * @author Michael Rosero
     * @param Product $product
     * @return Boolean Si es verdadero hay stock disponible, si es falso no hay stock disponible
     */
    protected static function validateStockProduct($product, $total)
    {
        try {

            $errors     = ["error"=>false, "message"=>NULL];

            //Error si sobrepasa cantidad general
            $count_prod = $product->producto->cantidad_stock;
            if(!($count_prod >= ((int) $total)))
            $errors = ["error"=>true,"message"=>self::ERROR_CANTIDAD];

            //Error si sobrepasa stock de talla o color
            $count_prod = $product->cantidad;
            if(!($count_prod >= ((int) $total)))
            $errors = ["error"=>true,"message"=>self::ERROR_CANTIDAD_STOCK];

            $estatus  = $product->producto->estado_producto_id;
            if($estatus != '1')
            $errors = ["error"=>true,"message"=>'El producto seleccionado se encuentra inactivo. Por favor, seleccione otro.'];
            
            return $errors;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Página de confirmación EPAYCO: En esta página se reciben las variables enviadas desde ePayco hacia el servidor.
     * Antes de realizar cualquier movimiento en base de datos se deben comprobar algunos valores
     * Es muy importante comprobar la firma enviada desde ePayco
     * Ingresar  el valor de p_cust_id_cliente, se encuentra en la configuración de la cuenta ePayco
     * Ingresar  el valor de p_key se encuentra en la configuración de la cuenta ePayco
     * @author Michael Rosero
     */
    public function actionPageConfirmation()
    {
        $p_cust_id_cliente = '32978';
        $p_key             = '656cb2c193fa0bad1afdf9cc3348223ee58818af';
        $x_ref_payco       = @$_REQUEST['x_ref_payco'];
        $x_transaction_id  = @$_REQUEST['x_transaction_id'];
        $x_amount          = @$_REQUEST['x_amount'];
        $x_currency_code   = @$_REQUEST['x_currency_code'];
        $x_signature       = @$_REQUEST['x_signature'];
        $signature = hash('sha256', $p_cust_id_cliente . '^' . $p_key . '^' . $x_ref_payco . '^' . $x_transaction_id . '^' . $x_amount . '^' . $x_currency_code);
        $x_response        = @$_REQUEST['x_response'];
        $x_motivo          = @$_REQUEST['x_response_reason_text'];
        $x_id_invoice      = @$_REQUEST['x_id_invoice'];
        $x_autorizacion    = @$_REQUEST['x_approval_code'];
        
        //Se valida la firma
        if ($x_signature == $signature) {

            $x_cod_response  = @$_REQUEST['x_cod_response'];

            $compra_producto = ProductoCompras::findAll(['codigo_factura' => $x_id_invoice]); 
            foreach($compra_producto as $update){
                $update->estado_id =  (int) $x_cod_response;
                $update->save();
            } 
            /*Si la firma esta bien podemos verificar los estado de la transacción*/
            switch ((int) $x_cod_response) {
                case 1:
                    # code transacción aceptada
                    //echo "transacción aceptada";
                    break;
                case 2:
                    # code transacción rechazada
                    //echo "transacción rechazada";
                    break;
                case 3:
                    # code transacción pendiente
                    //echo "transacción pendiente";
                    break;
                case 4:
                    # code transacción fallida
                    //echo "transacción fallida";
                    break;
            }
        } else {
            die("Firma no valida");
        }
    }


    /**
     * Envia al detalle del producto en la plantilla no administrativa
     * @param Integer $idProducto
     * @return type
     */
    public function actionDetalleProducto($idProducto)
    {
        $this->layout = 'main';
        $producto       = $this->findModel($idProducto);
        $get_prom_cal   = ProductoCalificacion::avgCalificacion($idProducto);

        return $this->render('producto_detalle', [
            'producto' => $producto,
            'prom_cal' => $get_prom_cal->calificacion
        ]);
    }

    /**
     * Realiza la eliminación de un producto del carrito de compras
     * @param type $idProducto
     */
    public function actionEliminarProducto($idProducto)
    {
        $product = ProductoTalla::findOne($idProducto);
        $cart = Yii::$app->cart;
        $cart->remove($product->id);
        return true;
    }

    public function actionActualizarProducto($idProducto, $cantidad)
    {
        $product = ProductoTalla::findOne($idProducto);
        $cart = Yii::$app->cart;
        $cart->change($product->id, $cantidad);
        $costo = 'COP $' . number_format($this->getTotalCost($cart), 0, ',', '.');
        return $costo;
    }
}