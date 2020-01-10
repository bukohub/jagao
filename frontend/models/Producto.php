<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\web\UploadedFile;
/**
 * This is the model class for table "producto".
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property int $cantidad_stock
 * @property double $precio_pesos

 * @property int $proveedor_id
 * @property int $estado_producto_id
 * @property double $calificacion_promedio
 * @property int $es_ropa_calzado
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property ImagenPrincipalProducto[] $imagenPrincipalProductos
 * @property ImagenProductoSecundaria[] $imagenProductoSecundarias
 * @property PreguntaProducto[] $preguntaProductos
 * @property Proveedor $proveedor
 * @property EstadoProducto $estadoProducto
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property ProductoCategoria[] $productoCategorias
 * @property ProductoColor[] $productoColors
 * @property ProductoTag[] $productoTags
 * @property ProductoTalla[] $productoTallas
 * @property ReporteProducto[] $reporteProductos
 * @property int $aplica_envio 
 * @property double $precio_envio 
 * @property double $precio_envio_adicional 
 * @property int $cantidad_gratis_envio 
 */
class Producto extends \common\models\MyActiveRecord {

    /**
     * Almacena tagas asociados
     * @var type 
     */
    public $tags;

    /**
     * Almacena las categorias a las que esta asociado
     * @var type 
     */
    public $categorias;
    
    public $subcategorias;

    /**
     * Almacena la imagen principal
     */
    public $imagen_principal;

    /**
     * Almacena las imagenes segundarias del producto
     * @var type 
     */
    public $imagenes_segundarias;

    /**
     *  Almacena la información de las tallas
     * @var type 
     */
    public $producto_tallas;

    /**
     * Almacena la información de los colores del producto
     * @var type 
     */
    public $producto_colors;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'producto';
    }
    /**
     * Anulación método find por defecto para validar que el producto esté asociado a un proveedor activo.
     */
  /*  public static function find()
    {
        return parent::find()->joinWith('proveedor p')->where(['p.estado_id' => 1]);
    }*/

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['nombre', 'descripcion', 'precio_pesos', 'proveedor_id', 'tags','subcategorias','aplica_envio'], 'required'],
            [['descripcion'], 'string'],
            [['cantidad_stock', 'proveedor_id', 'estado_producto_id', 'creado_por', 'actualizado_por', 'es_ropa_calzado','aplica_envio', 'cantidad_gratis_envio'], 'integer'],
            [['precio_pesos', 'calificacion_promedio', 'precio_envio', 'precio_envio_adicional'], 'number'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre'], 'string', 'max' => 255],
            [['imagen_principal'], 'file', 'extensions' => 'png, jpg'],
            [['imagenes_segundarias'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 6],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedor::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['estado_producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoProducto::className(), 'targetAttribute' => ['estado_producto_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
            'cantidad_stock' => 'Cantidad en stock',
            'precio_pesos' => 'Precio en pesos',
       
            'proveedor_id' => 'Proveedor',
            'estado_producto_id' => 'Estado',
            'calificacion_promedio' => 'Calificación promedio',
            'es_ropa_calzado' => '¿Es ropa o calzado?',
            'creado_por' => 'Creado por',
            'creado_el' => 'Fecha de creación',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'imagen_principal' => 'Imagen principal',
            'imagenes_segundarias' => 'Imagenes segundarias',
            'aplica_envio' => 'Aplica envío',
            'precio_envio' => 'Precio Envio',
            'precio_envio_adicional' => 'Precio Envio Adicional',
            'cantidad_gratis_envio' => 'Cantidad Gratis Envio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenPrincipalProductos() {
        return $this->hasOne(ImagenPrincipalProducto::className(), ['producto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenProductoSecundarias() {
        return $this->hasMany(ImagenProductoSecundaria::className(), ['producto_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoTag() {
        return $this->hasMany(ProductoTag::className(), ['producto_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */    
    public function getTag(){
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->via('productoTag');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreguntaProductos() {
        return $this->hasMany(PreguntaProducto::className(), ['producto_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPregunta(){
        return $this->hasOne(User::className(), ['id' => 'creado_por'])->via('preguntaProductos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedor() {
        return $this->hasOne(Proveedor::className(), ['id' => 'proveedor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoProducto() {
        return $this->hasOne(EstadoProducto::className(), ['id' => 'estado_producto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreadoPor() {
        return $this->hasOne(User::className(), ['id' => 'creado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActualizadoPor() {
        return $this->hasOne(User::className(), ['id' => 'actualizado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoCategorias() {
        return $this->hasMany(ProductoCategoria::className(), ['producto_id' => 'id']);
    }
    public function getProductoSubcategorias(){
        return $this->hasMany(ProductoSubcategoria::className(), ['producto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria(){
        return $this->hasMany(Subcategoria::className(), ['id' => 'subcategoria_id'])->via('productoSubcategorias');
    }
    public function getSubcategoria(){
        return $this->hasMany(Subcategoria::className(), ['id' => 'subcategoria_id'])->via('productoSubcategorias');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoTags() {
        return $this->hasMany(ProductoTag::className(), ['producto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReporteProductos() {
        return $this->hasMany(ReporteProducto::className(), ['producto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoColors() {
        return $this->hasMany(ProductoColor::className(), ['producto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoTallas() {
        return $this->hasMany(ProductoTalla::className(), ['producto_id' => 'id']);
    }

    public function getProductoTalla(){
        return $this->hasOne(ProductoTalla::className(), ['producto_id' => 'id']);
    }


    public function getProductoDescuentos(){
        return $this->hasOne(ProductoDescuentos::className(), ['producto_id' => 'id']);
    }

    public function getProductoCalificacion(){
        return $this->hasMany(ProductoCalificacion::className(), ['producto_id' => 'id']);
    }
    public function getUserCalificacion(){
        return $this->hasOne(User::className(), ['id' => 'creado_por'])->via('productoCalificacion');
    }
    
    public function getProductoCompras(){
        return $this->hasMany(ProductoCompras::className(), ['producto_id' => 'id']);
    }
    /**
     * Realiza la asociación de los tags a la publicación
     * @param type $tags
     */
    public function asociarTags($tags) {
        $this->eliminarTagAsociados();
        foreach ($tags as $tagEntrante) {
            $tagResultado = Tag::find()->where(['descripcion' => $tagEntrante])->one();
            if (empty($tagResultado)) {
                $tagNuevo = new Tag();
                $tagNuevo->descripcion = $tagEntrante;
                $tagNuevo->save();
            }
        }
        foreach ($tags as $tagEntrante2) {
            $tagAsociar = Tag::find()->where(['descripcion' => $tagEntrante2])->one();
            $tagPublicacion = new ProductoTag();
            $tagPublicacion->tag_id = $tagAsociar->id;
            $tagPublicacion->producto_id = $this->id;
            $tagPublicacion->save();
        }
    }

    /**
     * Realizo la eliminación de los tags que ya estan asociados
     * a la publicación
     */
    public function eliminarTagAsociados() {
        foreach ($this->productoTags as $tag) {
            $tag->delete();
        }
    }

    public function afterFind() {
        parent::afterFind();
        $tagsActuales = [];
        foreach ($this->productoTags as $tag) {
            $tagsActuales[] = $tag->tag->descripcion;
        }
        $this->tags = $tagsActuales;
        $subCategorias = [];
        foreach ($this->productoSubcategorias as $sub) {
            $subCategorias[] = $sub->subcategoria->id;
        }
        $this->subcategorias = $subCategorias;

        $categoriasActuales = [];
        foreach ($this->productoCategorias as $categoria) {
            $categoriasActuales[] = $categoria->categoria->id;
        }
        $this->categorias = $categoriasActuales;
        $this->producto_tallas = $this->productoTallas;
        $this->producto_colors = $this->productoColors;
    }

    /**
     * Almacena la imagen principal del producto
     */
    public function almacenarImagenPrincipal() {
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImagenes'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaImagenesProductos'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $archivo = UploadedFile::getInstance($this, 'imagen_principal');
        if (!empty($archivo)) {
            $imagenPrincipal = new ImagenPrincipalProducto();
            $imagenPrincipal->producto_id = $this->id;
            $imagenPrincipal->nombre_archivo_original = $archivo->name;
            $imagenPrincipal->nombre_archivo = uniqid('producto_' . $this->id . '_') . "." . $archivo->getExtension();
            $rutaCarpetaDocumento = $rutaCarpeta . 'producto' . $this->id . '/';
            if (!file_exists($rutaCarpetaDocumento)) {
                mkdir($rutaCarpetaDocumento);
            }
            $imagenPrincipal->ruta_archivo = $rutaCarpetaDocumento . $imagenPrincipal->nombre_archivo;
            if (!$imagenPrincipal->save()) {
                print_r($imagenPrincipal->getErrors());
                die();
            }
            $guardoBien = $archivo->saveAs($imagenPrincipal->ruta_archivo);
            $imagenPrincipal->nombre_archivo = 'producto' . $this->id . "/" . $imagenPrincipal->nombre_archivo;
            $imagenPrincipal->save();
            if (!$guardoBien) {
                $imagenPrincipal->delete();
            }
        }
    }

    /**
     * Almacena las imagenes segundarias de un producto
     */
    public function almacenarImagenesSegundarias() {
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImagenes'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaImagenesProductos'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        foreach ($this->imagenes_segundarias as $index => $imagenSegundaria) {
            $imagenSeg = new ImagenProductoSecundaria();
            $imagenSeg->producto_id = $this->id;
            $imagenSeg->nombre_archivo_original = $imagenSegundaria->name;
            $imagenSeg->nombre_archivo = uniqid('producto_' . $this->id . '_') . "." . $imagenSegundaria->getExtension();
            $rutaCarpetaDocumento = $rutaCarpeta . 'producto' . $this->id . '/';
            if (!file_exists($rutaCarpetaDocumento)) {
                mkdir($rutaCarpetaDocumento);
            }
            $imagenSeg->ruta_archivo = $rutaCarpetaDocumento . $imagenSeg->nombre_archivo;
            if (!$imagenSeg->save()) {
                print_r($imagenSeg->getErrors());
                die();
            }
            $guardoBien = $imagenSegundaria->saveAs($imagenSeg->ruta_archivo);
            $imagenSeg->nombre_archivo = 'producto' . $this->id . "/" . $imagenSeg->nombre_archivo;
            $imagenSeg->save();
            if (!$guardoBien) {
                $imagenSeg->delete();
            }
        }
    }

    /**
     * Asocia las categorias
     * @param type $categorias
     */
    public function asociarCategorias($categorias) {
        $this->eliminarRelacionCategoria();
        foreach ($categorias as $categoria) {
            $productoCategoria = new ProductoCategoria();
            $productoCategoria->producto_id = $this->id;
            $productoCategoria->categoria_id = $categoria;
            if (!$productoCategoria->save()) {
                print_r($productoCategoria->getErrors());
                die();
            }
        }
    }

    /**
     * Asocia las subcategorias
     * @param type $subcategorias
     */
    public function asociarSubcategorias($subcategorias) {
        $this->eliminarRelacionSubcategoria();
        foreach ($subcategorias as $subcategoria) {
            $productoSubcategoria = new ProductoSubcategoria();
            $productoSubcategoria->producto_id = $this->id;
            $productoSubcategoria->subcategoria_id = $subcategoria;
            if (!$productoSubcategoria->save()) {
                print_r($productoSubcategoria->getErrors());
                die();
            }
        }
    }
    /**
     * Elimina las subcategorias existentes
     */
    public function eliminarRelacionSubcategoria() {
        foreach ($this->productoSubcategorias as $subcategoria) {
            $subcategoria->delete();
        }
    }

    /**
     * Elimina las categorias existentes
     */
    public function eliminarRelacionCategoria() {
        foreach ($this->productoCategorias as $categoria) {
            $categoria->delete();
        }
    }

    /**
     * Asocia la cantidad del producto por la talla
     * @param type $tallas
     */
    public function asociarTallas($tallas) {
        $this->eliminarRelacionTallas();
        $this->eliminarRelacionColores();
        $sumatoriaCantidad = 0;
        foreach ($tallas as $talla) {
            $tallaNueva = new ProductoTalla();
            $tallaNueva->producto_id = $this->id;
            $tallaNueva->talla_id = $talla['talla_id'];
            $tallaNueva->cantidad = $talla['cantidad'];
            $sumatoriaCantidad += $tallaNueva->cantidad;
            $tallaNueva->codigo_color = $talla['codigo_color'];
            if (!$tallaNueva->save()) {
                print_r($tallaNueva->getErrors());
                die();
            }
        }
        $this->cantidad_stock = $sumatoriaCantidad;
    }

    /**
     * Elimina la relación que tenga con tallas existentes
     */
    public function eliminarRelacionTallas() {
        foreach ($this->productoTallas as $tallaExistente) {
            $tallaExistente->delete();
        }
    }

    /**
     * Asocia la cantidad del producto por el color
     * @param type $tallas
     */
    public function asociarColores($colores) {
        $this->eliminarRelacionColores();
        $this->eliminarRelacionTallas();
        $sumatoriaCantidad = 0;
        foreach ($colores as $color) {
            $colorNuevo = new ProductoColor();
            $colorNuevo->producto_id = $this->id;
            $colorNuevo->cantidad = (int)$color['cantidad'];
            $sumatoriaCantidad += $colorNuevo->cantidad;
            $colorNuevo->codigo_color = $color['codigo_color'];
            if (!$colorNuevo->save()) {
                print_r($colorNuevo->getErrors());
                die();
            }
        }
        $this->cantidad_stock = $sumatoriaCantidad;
    }

    /**
     * Elimina la relación que tenga con colores existentes
     */
    public function eliminarRelacionColores() {
        foreach ($this->productoColors as $color) {
            $color->delete();
        }
    }

}
