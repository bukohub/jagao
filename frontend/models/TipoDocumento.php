<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tipo_documento".
 *
 * @property int $id
 * @property string $id_tipo_documento
 * @property string $nombre
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property Proveedor[] $proveedors
 */
class TipoDocumento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_documento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipo_documento', 'nombre', 'creado_por', 'creado_el', 'actualizado_por', 'actualizado_el'], 'required'],
            [['creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['id_tipo_documento'], 'string', 'max' => 3],
            [['nombre'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tipo_documento' => 'Tipo Documento',
            'nombre' => 'Nombre',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedors()
    {
        return $this->hasMany(Proveedor::className(), ['tipo_documento' => 'id']);
    }
}
