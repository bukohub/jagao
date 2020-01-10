<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "pregunta_producto".
 *
 * @property int $id
 * @property int $producto_id
 * @property string $descripcion
 * @property int $estado_pregunta_id
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Producto $producto
 * @property EstadoPregunta $estadoPregunta
 * @property RespuestaProducto[] $respuestaProductos
 */
class PreguntaProducto extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pregunta_producto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'descripcion', 'estado_pregunta_id'], 'required'],
            [['producto_id', 'estado_pregunta_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['descripcion'], 'string'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['producto_id' => 'id']],
            [['estado_pregunta_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoPregunta::className(), 'targetAttribute' => ['estado_pregunta_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'producto_id' => 'Producto',
            'descripcion' => 'Descripción',
            'estado_pregunta_id' => 'Estado Pregunta ID',
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
    public function getProducto()
    {
        return $this->hasOne(Producto::className(), ['id' => 'producto_id']);
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
    public function getRespuestaProducto()
    {
        return $this->hasOne(RespuestaProducto::className(), ['pregunta_id' => 'id']);
    }
}
