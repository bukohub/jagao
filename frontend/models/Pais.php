<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "pais".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property DireccionCliente[] $direccionClientes
 * @property EstadoDepartamento[] $estadoDepartamentos
 */
class Pais extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pais';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDireccionClientes()
    {
        return $this->hasMany(DireccionCliente::className(), ['pais_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoDepartamentos()
    {
        return $this->hasMany(EstadoDepartamento::className(), ['pais_id' => 'id']);
    }
}
