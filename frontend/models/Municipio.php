<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "municipio".
 *
 * @property int $id
 * @property string $nombre
 * @property int $departamento_id
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property EstadoDepartamento $departamento
 */
class Municipio extends \yii\db\ActiveRecord
{
    public $name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'municipio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['departamento_id'], 'required'],
            [['departamento_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre'], 'string', 'max' => 100],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoDepartamento::className(), 'targetAttribute' => ['departamento_id' => 'id']],
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
            'departamento_id' => 'Departamento ID',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'name'=>'name'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamento()
    {
        return $this->hasOne(EstadoDepartamento::className(), ['id' => 'departamento_id']);
    }
}
