<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "producto_compras".
 *
 * @property string $id
 * @property string $producto_id
 * @property string $estado_id
 * @property string $user_id
 * @property string $descripcion
 * @property string $creado_por
 * @property string $creado_el
 * @property string $actualizado_por
 * @property string $actualizado_el
 *
 * @property Producto $producto
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property EstadoCompra $estado
 * @property User $producto0
 */
class ProductoCompras extends \common\models\MyActiveRecord
{
    public $seguimiento,$proveedor;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producto_compras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'estado_id', 'descripcion','codigo_factura'], 'required'],
            [['user_id'],'required','message' => 'Para continuar tu compra por favor <a href="'.Url::to(['site/login']).'">inicia sesión</a>. Si no tienes una cuenta puedes crear una dando clic en <a href="'.Url::to(['site/signup']).'">regístrate</a>.'],
            [['producto_id', 'estado_id', 'user_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['precio_costo', 'costo_envio', 'precio_total'], 'number'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['descripcion'], 'string', 'max' => 500],
            [['codigo_factura'], 'string', 'max' => 50], 
            [['numero_guia','nombre_transportadora'], 'string', 'max' => 45],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['producto_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoCompra::className(), 'targetAttribute' => ['estado_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id'],'message' => 'Por favor loguéate para poder finalizar la compra. <a href="/site/login">Ingresar</a>.'], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'producto_id' => 'Producto',
            'estado_id' => 'Estado',
            'user_id' => 'Usuario',
            'codigo_factura' => 'Código Factura',
            'descripcion' => 'Descripción',
            'numero_guia' => 'Guía',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'cantidad' => 'Cantidad',
            'precio_costo' => 'Precio Costo',
            'costo_envio' => 'Costo Envio',
            'precio_total' => 'Precio Total',
            'nombre_transportadora'=>'Nombre Transportadora',
            'pago_proveedor'=>'Pagado a proveedor'
        ];
    }
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getUser() 
   { 
       return $this->hasOne(User::className(), ['id' => 'user_id']); 
   } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Producto::className(), ['id' => 'producto_id']);
    }
    /**
     * @author Michael Rosero
     */
    public function getProveedor(){
        return $this->hasMany(Proveedor::className(), ['id' => 'proveedor_id'])->via('producto');
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
    public function getCreadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'creado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(EstadoCompra::className(), ['id' => 'estado_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoTalla()
    {
        return $this->hasOne(ProductoTalla::className(), ['id' => 'producto_id_talla']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformacionCompra()
    {
        return $this->hasOne(InformacionCompra::className(), ['id' => 'id_info_compra']);
    }

    public function almacenarSeguimiento($model, $numguia){
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImagenes'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaImagenesSeguimiento'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $archivo = UploadedFile::getInstance($this, 'seguimiento');
        if (!empty($archivo)) {            
            $imagenPrincipal = $model;
            $imagenPrincipal->numero_guia = $numguia;
            $imagenPrincipal->nombre_archivo_original = $archivo->name;
            $imagenPrincipal->nombre_archivo = uniqid('seguimiento_' . $this->id . '_') . "." . $archivo->getExtension();
            $rutaCarpetaDocumento = $rutaCarpeta . 'seguimiento' . $this->id . '/';
            if (!file_exists($rutaCarpetaDocumento)) {
                mkdir($rutaCarpetaDocumento);
            }
           
            $imagenPrincipal->ruta_archivo = $rutaCarpetaDocumento . $imagenPrincipal->nombre_archivo;
          
            if (!$imagenPrincipal->save()) {
                print_r($imagenPrincipal->getErrors());
                die();
            }
           
            $guardoBien = $archivo->saveAs($imagenPrincipal->ruta_archivo);
            $imagenPrincipal->nombre_archivo = 'seguimiento' . $this->id . "/" . $imagenPrincipal->nombre_archivo;
            $imagenPrincipal->save();
            if (!$guardoBien) {
                $imagenPrincipal->delete();
            }
            return ($imagenPrincipal->id);
        }
    }


}
