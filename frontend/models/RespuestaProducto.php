<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "respuesta_producto".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $estado_pregunta_id
 * @property int $pregunta_id
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property EstadoPregunta $estadoPregunta
 * @property EstadoPregunta $estadoPregunta0
 * @property PreguntaProducto $pregunta
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class RespuestaProducto extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respuesta_producto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'estado_pregunta_id', 'pregunta_id'], 'required'],
            [['descripcion'], 'string'],
            [['estado_pregunta_id', 'pregunta_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['estado_pregunta_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoPregunta::className(), 'targetAttribute' => ['estado_pregunta_id' => 'id']],
            [['estado_pregunta_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoPregunta::className(), 'targetAttribute' => ['estado_pregunta_id' => 'id']],
            [['pregunta_id'], 'exist', 'skipOnError' => true, 'targetClass' => PreguntaProducto::className(), 'targetAttribute' => ['pregunta_id' => 'id']],
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
            'descripcion' => 'Descripcion',
            'estado_pregunta_id' => 'Estado Pregunta ID',
            'pregunta_id' => 'Pregunta ID',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoPregunta()
    {
        return $this->hasOne(EstadoPregunta::className(), ['id' => 'estado_pregunta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoPregunta0()
    {
        return $this->hasOne(EstadoPregunta::className(), ['id' => 'estado_pregunta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPregunta()
    {
        return $this->hasOne(PreguntaProducto::className(), ['id' => 'pregunta_id']);
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
