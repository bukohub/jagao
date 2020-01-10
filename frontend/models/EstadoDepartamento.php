<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "estado_departamento".
 *
 * @property int $id
 * @property int $pais_id
 * @property string $nombre
 *
 * @property DireccionCliente[] $direccionClientes
 * @property Pais $pais
 */
class EstadoDepartamento extends \common\models\MyActiveRecord
{
    public $name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estado_departamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pais_id', 'nombre'], 'required'],
            [['pais_id'], 'integer'],
            [['nombre'], 'string', 'max' => 255],
            [['pais_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['pais_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pais_id' => 'Pais ID',
            'nombre' => 'Nombre',
            'name'=>'name'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDireccionClientes()
    {
        return $this->hasMany(DireccionCliente::className(), ['departamento_estado_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'pais_id']);
    }
}
