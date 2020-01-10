<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "runt_proveedor".
 *
 * @property int $id
 * @property string $proveedor_id
 * @property string $nombre_archivo_original
 * @property string $nombre_archivo
 * @property string $ruta_archivo
 * @property string $creado_por
 * @property string $creado_el
 * @property string $actualizado_por
 * @property string $actualizado_el
 *
 * @property Proveedor $proveedor
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class RuntProveedor extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'runt_proveedor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proveedor_id', 'nombre_archivo_original', 'nombre_archivo', 'ruta_archivo'], 'required'],
            [['id', 'proveedor_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre_archivo_original', 'nombre_archivo'], 'string', 'max' => 255],
            [['ruta_archivo'], 'string', 'max' => 355],
            [['id'], 'unique'],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedor::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
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
            'proveedor_id' => 'Proveedor ID',
            'nombre_archivo_original' => 'Nombre Archivo Original',
            'nombre_archivo' => 'Nombre Archivo',
            'ruta_archivo' => 'Ruta Archivo',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedor()
    {
        return $this->hasOne(Proveedor::className(), ['id' => 'proveedor_id']);
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
    public function getActualizadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'actualizado_por']);
    }
}
