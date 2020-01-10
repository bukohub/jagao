<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tipo_persona".
 *
 * @property int $id
 * @property string $id_tipo_persona
 * @property string $nombre
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property Proveedor[] $proveedors
 */
class TipoPersona extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_persona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'creado_por', 'creado_el', 'actualizado_por', 'actualizado_el'], 'required'],
            [['creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['id_tipo_persona'], 'string', 'max' => 3],
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
            'id_tipo_persona' => 'Id Tipo Persona',
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
        return $this->hasMany(Proveedor::className(), ['tipo_cuenta' => 'id']);
    }
}
