<?php

namespace frontend\models;
use common\models\User;

use Yii;

/**
 * This is the model class for table "producto_calificacion".
 *
 * @property string $id
 * @property string $producto_id
 * @property string $calificacion
 * @property string $creado_por
 * @property string $creado_el
 * @property string $actualizado_por
 * @property string $actualizado_el
 * @property string $descripcion
 * @property User $actualizadoPor
 * @property User $creadoPor
 * @property Producto $producto
 */
class ProductoCalificacion extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producto_calificacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'calificacion'], 'required'],
            [['producto_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['calificacion'], 'number'],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['producto_id' => 'id']],
            [['descripcion'], 'string', 'max' => 500],
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
            'calificacion' => 'Calificacion',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'descripcion' => 'Descripcion',
        ];
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
    public function getCreadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'creado_por']);
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreadoPor0()
    {
        return $this->hasOne(User::className(), ['id' => 'creado_por']);
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
    public function getProductoCompras()
    {
        return $this->hasOne(ProductoCompras::className(), ['producto_id' => 'producto_id','user_id'=>'creado_por']);
    }
    /**
     * Método para obtener el promedio de calificaciones de un producto
     * @author Michael Rosero
     */
    public static function avgCalificacion($idProducto){
       return ProductoCalificacion::findBySql('SELECT AVG(calificacion) as calificacion FROM producto_calificacion where producto_id=:producto_id',array(':producto_id'=>$idProducto))->one();
    }
}
