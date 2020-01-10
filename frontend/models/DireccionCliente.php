<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "direccion_cliente".
 *
 * @property int $id
 * @property int $pais_id
 * @property int $departamento_estado_id
 * @property string $ciudad
 * @property string $detalle
 * @property int $usuario_id
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property Pais $pais
 * @property EstadoDepartamento $departamentoEstado
 * @property User $usuario
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class DireccionCliente extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'direccion_cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pais_id', 'departamento_estado_id', 'ciudad', 'detalle', 'usuario_id'], 'required'],
            [['pais_id', 'departamento_estado_id', 'usuario_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['ciudad', 'detalle'], 'string', 'max' => 255],
            [['pais_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['pais_id' => 'id']],
            [['departamento_estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoDepartamento::className(), 'targetAttribute' => ['departamento_estado_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
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
            'pais_id' => 'Pais',
            'departamento_estado_id' => 'Departamento/Estado',
            'ciudad' => 'Ciudad',
            'detalle' => 'Detalle',
            'usuario_id' => 'Usuario ID',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'pais_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamentoEstado()
    {
        return $this->hasOne(EstadoDepartamento::className(), ['id' => 'departamento_estado_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipio()
    {
        return $this->hasOne(Municipio::className(), ['id' => 'ciudad']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id']);
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
