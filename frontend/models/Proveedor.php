<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\web\UploadedFile;

/**
 * This is the model class for table "proveedor".
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $identificacion_nit
 * @property int $usuario_id
 * @property int $estado_id
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property ImagenProveedor[] $imagenProveedors
 * @property Producto[] $productos
 * @property User $usuario
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Estado $estado
 * @property ResultadoRevisionProveedor[] $resultadoRevisionProveedors
 */
class Proveedor extends \common\models\MyActiveRecord {

    public $imagen, $runt;

    public $documento;

    public $certificado_bk;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'proveedor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion', 'identificacion_nit', 'nombre_propietario', 'tipo_documento_propietario', 'no_doc_propietario', 'nombre_archivo_original', 'nombre_archivo', 'ruta_archivo', 'usuario_id', 'estado_id', 'banco', 'tipo_cuenta', 'numero_cuenta', 'tipo_documento', 'no_documento', 'nombre_destinatario'], 'required'],
            [['contrato'],'required','message'=>'Debes aceptar para continuar'],
            [['descripcion'], 'string'],
            [['tipo_documento_propietario', 'no_doc_propietario', 'usuario_id', 'estado_id', 'banco', 'tipo_cuenta', 'tipo_documento', 'contrato', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre', 'nombre_propietario', 'nombre_archivo_original', 'nombre_archivo', 'ruta_archivo'], 'string', 'max' => 255],
            [['identificacion_nit'], 'string', 'max' => 20],
            [['facebook', 'instagram', 'twitter'], 'string', 'max' => 200],
            [['numero_cuenta', 'codigo_epayco'], 'string', 'max' => 45],
            [['no_documento'], 'string', 'max' => 55],
            [['mensaje_ina'], 'string', 'max' => 300],
            [['nombre_destinatario'], 'string', 'max' => 75],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['estado_id' => 'id']],
            [['tipo_documento_propietario'], 'exist', 'skipOnError' => true, 'targetClass' => TipoDocumento::className(), 'targetAttribute' => ['tipo_documento_propietario' => 'id']],
            [['tipo_documento'], 'exist', 'skipOnError' => true, 'targetClass' => TipoDocumento::className(), 'targetAttribute' => ['tipo_documento' => 'id']],
            [['tipo_cuenta'], 'exist', 'skipOnError' => true, 'targetClass' => TipoPersona::className(), 'targetAttribute' => ['tipo_cuenta' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre de la compañía',
            'descripcion' => 'Descripcion de la Actividad Comercial',
            'identificacion_nit' => 'NIT',
            'nombre_propietario' => 'Nombre Propietario o Representante Legal',
            'tipo_documento_propietario' => 'Tipo de Documento',
            'no_doc_propietario' => 'Número de Documento',
            'nombre_archivo_original' => 'Nombre Archivo Original',
            'nombre_archivo' => 'Nombre Archivo',
            'ruta_archivo' => 'Ruta Archivo',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter',
            'usuario_id' => 'Usuario ID',
            'estado_id' => 'Estado ID',
            'banco' => 'Banco',
            'tipo_cuenta' => 'Tipo de Cuenta',
            'numero_cuenta' => 'Número de Cuenta',
            'tipo_documento' => 'Tipo de Documento',
            'no_documento' => 'Número de Documento',
            'nombre_destinatario' => 'Titular de la Cuenta',
            'contrato' => 'Contrato',
            'codigo_epayco' => 'Codigo Epayco',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'imagen'=>'Logotipo de la Compañía',
            'mensaje_ina'=>'Mensaje de Inactivación de Proveedor'
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenProveedors() {
        return $this->hasOne(ImagenProveedor::className(), ['proveedor_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuntProveedor() {
        return $this->hasOne(RuntProveedor::className(), ['proveedor_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos() {
        return $this->hasMany(Producto::className(), ['proveedor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario() {
        return $this->hasOne(User::className(), ['id' => 'usuario_id']);
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
    public function getEstado() {
        return $this->hasOne(Estado::className(), ['id' => 'estado_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultadoRevisionProveedors() {
        return $this->hasMany(ResultadoRevisionProveedor::className(), ['proveedor_id' => 'id']);
    }



    /**
     * Realiza la asociación de la imagen con la categoría
     */
    public function almacenarImagen() {
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImagenes'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaImagenesProveedores'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $archivo = UploadedFile::getInstance($this, 'imagen');
        if (!empty($archivo)) {
            $imagen = new ImagenProveedor();
            $imagen->nombre_archivo_original = $archivo->name;
            $imagen->nombre_archivo = uniqid('proveedor_' . $this->id . '_') . "." . $archivo->getExtension();
            $rutaCarpetaDocumento = $rutaCarpeta . 'proveedor' . $this->id . '/';
            if (!file_exists($rutaCarpetaDocumento)) {
                mkdir($rutaCarpetaDocumento);
            }
            $imagen->ruta_archivo = $rutaCarpetaDocumento . $imagen->nombre_archivo;
            $imagen->proveedor_id = $this->id;
            if (!$imagen->save()) {
                print_r($imagen->getErrors());
                die();
            }
            $guardoBien = $archivo->saveAs($imagen->ruta_archivo);
            $imagen->nombre_archivo = 'proveedor' . $this->id . "/" . $imagen->nombre_archivo;
            $imagen->save();
            if (!$guardoBien) {
                $imagen->delete();
            }
            $this->save();
        }
    }

    /**
     * Realiza la asociación del runt con proveedor
     */
    public function almacenarProveedor() {
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImagenes'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaRuntProveedores'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $archivo = UploadedFile::getInstance($this, 'runt');
        if (!empty($archivo)) {
            $imagen = new RuntProveedor();
            $imagen->nombre_archivo_original = $archivo->name;
            $imagen->nombre_archivo = uniqid('runtProveedor_' . $this->id . '_') . "." . $archivo->getExtension();
            $rutaCarpetaDocumento = $rutaCarpeta . 'runtProveedor_' . $this->id . '/';
            if (!file_exists($rutaCarpetaDocumento)) {
                mkdir($rutaCarpetaDocumento);
            }
            $imagen->ruta_archivo = $rutaCarpetaDocumento . $imagen->nombre_archivo;
            $imagen->proveedor_id = $this->id;
            if (!$imagen->save()) {
                print_r($imagen->getErrors());
                die();
            }
            $guardoBien = $archivo->saveAs($imagen->ruta_archivo);
            $imagen->nombre_archivo = 'runtProveedor_' . $this->id . "/" . $imagen->nombre_archivo;
            $imagen->save();
            if (!$guardoBien) {
                $imagen->delete();
            }
            $this->save();
        }
    }

/**
     * Realiza la asociación del runt con proveedor
     */
    public function almacenarDocumento($imagen) {
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImagenes'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaDocProveedores'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $archivo = UploadedFile::getInstance($this, 'documento');
        if (!empty($archivo)) {
            $imagen->nombre_archivo_original = $archivo->name;
            $imagen->nombre_archivo = uniqid('documentoProveedor_' . $this->usuario_id . '_') . "." . $archivo->getExtension();
            $rutaCarpetaDocumento = $rutaCarpeta . 'documentoProveedor_' . $this->usuario_id . '/';
            if (!file_exists($rutaCarpetaDocumento)) {
                mkdir($rutaCarpetaDocumento);
            }
            $imagen->ruta_archivo = $rutaCarpetaDocumento . $imagen->nombre_archivo;
            if (!$imagen->save()) {
                print_r($imagen->getErrors());
                die();
            }
            $guardoBien = $archivo->saveAs($imagen->ruta_archivo);
            $imagen->nombre_archivo = 'documentoProveedor_' . $this->usuario_id . "/" . $imagen->nombre_archivo;
            $imagen->save();
            if (!$guardoBien) {
                $imagen->delete();
            }
            $this->save();
        }
    }


    public function almacenarCertificadoBank($imagen) {
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImagenes'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaCertProveedores'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $archivo = UploadedFile::getInstance($this, 'certificado_bk');
        if (!empty($archivo)) {
            $imagen->nombre_cert_original = $archivo->name;
            $imagen->nombre_cert = uniqid('certificadoProveedor_' . $this->usuario_id . '_') . "." . $archivo->getExtension();
            $rutaCarpetaDocumento = $rutaCarpeta . 'certificadoProveedor_' . $this->usuario_id . '/';
            if (!file_exists($rutaCarpetaDocumento)) {
                mkdir($rutaCarpetaDocumento);
            }
            $imagen->ruta_cert = $rutaCarpetaDocumento . $imagen->nombre_cert;
            if (!$imagen->save()) {
                print_r($imagen->getErrors());
                die();
            }
            $guardoBien = $archivo->saveAs($imagen->ruta_cert);
            $imagen->nombre_cert = 'certificadoProveedor_' . $this->usuario_id . "/" . $imagen->nombre_cert;
            $imagen->save();
            if (!$guardoBien) {
                $imagen->delete();
            }
            $this->save();
        }
    }

    public function eliminarImagenActual() {
        $this->imagenProveedors->delete();
    }

    public function getTipoDocumento()
    {
        return $this->hasOne(TipoDocumento::className(), ['id' => 'tipo_documento']);
    }
    public function getTipoCuenta()
   {
       return $this->hasOne(TipoPersona::className(), ['id' => 'tipo_cuenta']);
   }
    /**
     * @return \yii\db\ActiveQuery
    */
    public function getBancos() {
        return $this->hasOne(Bancos::className(), ['id' => 'banco']);
    }
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTipoDocumentoPropietario()
    {
        return $this->hasOne(TipoDocumento::className(), ['id' => 'tipo_documento_propietario']);
    }

}
