<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id ID
 * @property string $name Nombres
 * @property string $surname Apellidos
 * @property string $username Nombre de usuario
 * @property string $email Correo personal
 * @property int $estado ¿Está activo?
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property int $creado_por Creado por
 * @property string $created_at Creado el
 * @property int $actualizado_por Actualizado por
 * @property string $updated_at Modificado el
 *
 * @property AcercaJagao[] $acercaJagaos
 * @property AcercaJagao[] $acercaJagaos0
 * @property AuthAssignment[] $authAssignments
 * @property AuthItem[] $itemNames
 * @property AuthMenuItem[] $authMenuItems
 * @property AuthMenuItem[] $authMenuItems0
 * @property Bancos[] $bancos
 * @property Bancos[] $bancos0
 * @property Categoria[] $categorias
 * @property Categoria[] $categorias0
 * @property DireccionCliente[] $direccionClientes
 * @property DireccionCliente[] $direccionClientes0
 * @property DireccionCliente[] $direccionClientes1
 * @property Estado[] $estados
 * @property Estado[] $estados0
 * @property EstadoCompra[] $estadoCompras
 * @property EstadoCompra[] $estadoCompras0
 * @property EstadoPagoProveedor[] $estadoPagoProveedors
 * @property EstadoPagoProveedor[] $estadoPagoProveedors0
 * @property EstadoPregunta[] $estadoPreguntas
 * @property EstadoPregunta[] $estadoPreguntas0
 * @property EstadoProducto[] $estadoProductos
 * @property EstadoProducto[] $estadoProductos0
 * @property ImagenBanner[] $imagenBanners
 * @property ImagenBanner[] $imagenBanners0
 * @property ImagenPrincipalProducto[] $imagenPrincipalProductos
 * @property ImagenPrincipalProducto[] $imagenPrincipalProductos0
 * @property ImagenProductoSecundaria[] $imagenProductoSecundarias
 * @property ImagenProductoSecundaria[] $imagenProductoSecundarias0
 * @property ImagenProveedor[] $imagenProveedors
 * @property ImagenProveedor[] $imagenProveedors0
 * @property InformacionCompra[] $informacionCompras
 * @property InformacionCompra[] $informacionCompras0
 * @property PreguntaProducto[] $preguntaProductos
 * @property PreguntaProducto[] $preguntaProductos0
 * @property Producto[] $productos
 * @property Producto[] $productos0
 * @property ProductoCalificacion[] $productoCalificacions
 * @property ProductoCalificacion[] $productoCalificacions0
 * @property ProductoCategoria[] $productoCategorias
 * @property ProductoCategoria[] $productoCategorias0
 * @property ProductoColor[] $productoColors
 * @property ProductoColor[] $productoColors0
 * @property ProductoCompras[] $productoCompras
 * @property ProductoCompras[] $productoCompras0
 * @property ProductoCompras[] $productoCompras1
 * @property ProductoDescuentos[] $productoDescuentos
 * @property ProductoDescuentos[] $productoDescuentos0
 * @property ProductoSubcategoria[] $productoSubcategorias
 * @property ProductoSubcategoria[] $productoSubcategorias0
 * @property ProductoTag[] $productoTags
 * @property ProductoTag[] $productoTags0
 * @property ProductoTalla[] $productoTallas
 * @property ProductoTalla[] $productoTallas0
 * @property Proveedor[] $proveedors
 * @property Proveedor[] $proveedors0
 * @property Proveedor[] $proveedors1
 * @property ReporteProducto[] $reporteProductos
 * @property ReporteProducto[] $reporteProductos0
 * @property RespuestaProducto[] $respuestaProductos
 * @property RespuestaProducto[] $respuestaProductos0
 * @property ResultadoRevisionCategoria[] $resultadoRevisionCategorias
 * @property ResultadoRevisionCategoria[] $resultadoRevisionCategorias0
 * @property ResultadoRevisionProveedor[] $resultadoRevisionProveedors
 * @property ResultadoRevisionProveedor[] $resultadoRevisionProveedors0
 * @property RuntProveedor[] $runtProveedors
 * @property RuntProveedor[] $runtProveedors0
 * @property Subcategoria[] $subcategorias
 * @property Subcategoria[] $subcategorias0
 * @property Tag[] $tags
 * @property Tag[] $tags0
 * @property Talla[] $tallas
 * @property Talla[] $tallas0
 * @property TerminosJagao[] $terminosJagaos
 * @property TerminosJagao $terminosJagao
 * @property TipoReporteProducto[] $tipoReporteProductos
 * @property TipoReporteProducto[] $tipoReporteProductos0
 * @property User $creadoPor
 * @property User[] $users
 * @property User $actualizadoPor
 * @property User[] $users0
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'username', 'estado', 'auth_key', 'password_hash', 'verification_token', 'created_at'], 'required'],
            [['estado', 'creado_por', 'actualizado_por'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'surname', 'email'], 'string', 'max' => 100],
            [['username'], 'string', 'max' => 20],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'verification_token'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'surname' => 'Apellidos',
            'username' => 'Usuario',
            'email' => 'Email',
            'estado' => 'Estado',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'verification_token' => 'Verification Token',
            'creado_por' => 'Creado Por',
            'created_at' => 'Created At',
            'actualizado_por' => 'Actualizado Por',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcercaJagaos()
    {
        return $this->hasMany(AcercaJagao::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcercaJagaos0()
    {
        return $this->hasMany(AcercaJagao::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemNames()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'item_name'])->viaTable('auth_assignment', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthMenuItems()
    {
        return $this->hasMany(AuthMenuItem::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthMenuItems0()
    {
        return $this->hasMany(AuthMenuItem::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBancos()
    {
        return $this->hasMany(Bancos::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBancos0()
    {
        return $this->hasMany(Bancos::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasMany(Categoria::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias0()
    {
        return $this->hasMany(Categoria::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDireccionClientes()
    {
        return $this->hasMany(DireccionCliente::className(), ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDireccionClientes0()
    {
        return $this->hasMany(DireccionCliente::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDireccionClientes1()
    {
        return $this->hasMany(DireccionCliente::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstados()
    {
        return $this->hasMany(Estado::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstados0()
    {
        return $this->hasMany(Estado::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoCompras()
    {
        return $this->hasMany(EstadoCompra::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoCompras0()
    {
        return $this->hasMany(EstadoCompra::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoPagoProveedors()
    {
        return $this->hasMany(EstadoPagoProveedor::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoPagoProveedors0()
    {
        return $this->hasMany(EstadoPagoProveedor::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoPreguntas()
    {
        return $this->hasMany(EstadoPregunta::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoPreguntas0()
    {
        return $this->hasMany(EstadoPregunta::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoProductos()
    {
        return $this->hasMany(EstadoProducto::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoProductos0()
    {
        return $this->hasMany(EstadoProducto::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenBanners()
    {
        return $this->hasMany(ImagenBanner::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenBanners0()
    {
        return $this->hasMany(ImagenBanner::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenPrincipalProductos()
    {
        return $this->hasMany(ImagenPrincipalProducto::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenPrincipalProductos0()
    {
        return $this->hasMany(ImagenPrincipalProducto::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenProductoSecundarias()
    {
        return $this->hasMany(ImagenProductoSecundaria::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenProductoSecundarias0()
    {
        return $this->hasMany(ImagenProductoSecundaria::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenProveedors()
    {
        return $this->hasMany(ImagenProveedor::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenProveedors0()
    {
        return $this->hasMany(ImagenProveedor::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformacionCompras()
    {
        return $this->hasMany(InformacionCompra::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformacionCompras0()
    {
        return $this->hasMany(InformacionCompra::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreguntaProductos()
    {
        return $this->hasMany(PreguntaProducto::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreguntaProductos0()
    {
        return $this->hasMany(PreguntaProducto::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos0()
    {
        return $this->hasMany(Producto::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoCalificacions()
    {
        return $this->hasMany(ProductoCalificacion::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoCalificacions0()
    {
        return $this->hasMany(ProductoCalificacion::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoCategorias()
    {
        return $this->hasMany(ProductoCategoria::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoCategorias0()
    {
        return $this->hasMany(ProductoCategoria::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoColors()
    {
        return $this->hasMany(ProductoColor::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoColors0()
    {
        return $this->hasMany(ProductoColor::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoCompras()
    {
        return $this->hasMany(ProductoCompras::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoCompras0()
    {
        return $this->hasMany(ProductoCompras::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoCompras1()
    {
        return $this->hasMany(ProductoCompras::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoDescuentos()
    {
        return $this->hasMany(ProductoDescuentos::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoDescuentos0()
    {
        return $this->hasMany(ProductoDescuentos::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoSubcategorias()
    {
        return $this->hasMany(ProductoSubcategoria::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoSubcategorias0()
    {
        return $this->hasMany(ProductoSubcategoria::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoTags()
    {
        return $this->hasMany(ProductoTag::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoTags0()
    {
        return $this->hasMany(ProductoTag::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoTallas()
    {
        return $this->hasMany(ProductoTalla::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoTallas0()
    {
        return $this->hasMany(ProductoTalla::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedors()
    {
        return $this->hasMany(Proveedor::className(), ['usuario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedors0()
    {
        return $this->hasMany(Proveedor::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedors1()
    {
        return $this->hasMany(Proveedor::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReporteProductos()
    {
        return $this->hasMany(ReporteProducto::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReporteProductos0()
    {
        return $this->hasMany(ReporteProducto::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestaProductos()
    {
        return $this->hasMany(RespuestaProducto::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestaProductos0()
    {
        return $this->hasMany(RespuestaProducto::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultadoRevisionCategorias()
    {
        return $this->hasMany(ResultadoRevisionCategoria::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultadoRevisionCategorias0()
    {
        return $this->hasMany(ResultadoRevisionCategoria::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultadoRevisionProveedors()
    {
        return $this->hasMany(ResultadoRevisionProveedor::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultadoRevisionProveedors0()
    {
        return $this->hasMany(ResultadoRevisionProveedor::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuntProveedors()
    {
        return $this->hasMany(RuntProveedor::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuntProveedors0()
    {
        return $this->hasMany(RuntProveedor::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategorias()
    {
        return $this->hasMany(Subcategoria::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategorias0()
    {
        return $this->hasMany(Subcategoria::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags0()
    {
        return $this->hasMany(Tag::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTallas()
    {
        return $this->hasMany(Talla::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTallas0()
    {
        return $this->hasMany(Talla::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerminosJagaos()
    {
        return $this->hasMany(TerminosJagao::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerminosJagao()
    {
        return $this->hasOne(TerminosJagao::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoReporteProductos()
    {
        return $this->hasMany(TipoReporteProducto::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoReporteProductos0()
    {
        return $this->hasMany(TipoReporteProducto::className(), ['actualizado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'creado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['creado_por' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActualizadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'actualizado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers0()
    {
        return $this->hasMany(User::className(), ['actualizado_por' => 'id']);
    }
}
