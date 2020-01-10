<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "estado_pregunta".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property PreguntaProducto[] $preguntaProductos
 * @property RespuestaProducto[] $respuestaProductos
 * @property RespuestaProducto[] $respuestaProductos0
 */
class EstadoPregunta extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estado_pregunta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['descripcion'], 'string'],
            [['creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
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
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreguntaProductos()
    {
        return $this->hasMany(PreguntaProducto::className(), ['estado_pregunta_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestaProductos()
    {
        return $this->hasMany(RespuestaProducto::className(), ['estado_pregunta_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestaProductos0()
    {
        return $this->hasMany(RespuestaProducto::className(), ['estado_pregunta_id' => 'id']);
    }
}
