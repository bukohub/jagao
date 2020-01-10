<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\web\UploadedFile;

/**
 * This is the model class for table "imagen_banner".
 *
 * @property int $id
 * @property string $descripcion_principal
 * @property string $descripcion_secundaria
 * @property string $nombre_archivo_original
 * @property string $nombre_archivo
 * @property string $ruta_archivo
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 */
class ImagenBanner extends \common\models\MyActiveRecord
{
    public $banners;
 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagen_banner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_archivo_original', 'nombre_archivo', 'ruta_archivo'], 'required'],
            [['creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['descripcion_principal', 'descripcion_secundaria'], 'string', 'max' => 400],
            [['nombre_archivo_original', 'nombre_archivo'], 'string', 'max' => 255],
            [['ruta_archivo'], 'string', 'max' => 355],
            [['banners'], 'file', 'extensions' => 'png, jpg,jpeg', 'maxFiles' => 6],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion_principal' => 'Descripcion Principal',
            'descripcion_secundaria' => 'Descripcion Secundaria',
            'nombre_archivo_original' => 'Nombre Archivo Original',
            'nombre_archivo' => 'Nombre Archivo',
            'ruta_archivo' => 'Ruta Archivo',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'banners' => 'Subir Banner',
        ];
    }

    public function almacenarBanners($desc, $parr){
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImagenes'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaImagenesProductos'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $archivo = UploadedFile::getInstance($this, 'banners');
        if (!empty($archivo)) {            
            $imagenPrincipal = new ImagenBanner();
            $imagenPrincipal->descripcion_principal = $desc;
            $imagenPrincipal->descripcion_secundaria = $parr;
            $imagenPrincipal->nombre_archivo_original = $archivo->name;
            $imagenPrincipal->nombre_archivo = uniqid('banners_' . $this->id . '_') . "." . $archivo->getExtension();
            $rutaCarpetaDocumento = $rutaCarpeta . 'banners' . $this->id . '/';
            if (!file_exists($rutaCarpetaDocumento)) {
                mkdir($rutaCarpetaDocumento);
            }
           
            $imagenPrincipal->ruta_archivo = $rutaCarpetaDocumento . $imagenPrincipal->nombre_archivo;
          
            if (!$imagenPrincipal->save()) {
                print_r($imagenPrincipal->getErrors());
                die();
            }
           
            $guardoBien = $archivo->saveAs($imagenPrincipal->ruta_archivo);
            $imagenPrincipal->nombre_archivo = 'banners' . $this->id . "/" . $imagenPrincipal->nombre_archivo;
            $imagenPrincipal->save();
            if (!$guardoBien) {
                $imagenPrincipal->delete();
            }
            return ($imagenPrincipal->id);
        }
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
}
