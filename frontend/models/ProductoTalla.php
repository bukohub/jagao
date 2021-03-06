<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "producto_talla".
 *
 * @property int $id
 * @property int $producto_id
 * @property int $talla_id
 * @property string $codigo_color
 * @property int $cantidad
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Producto $producto
 * @property Talla $talla
 */
class ProductoTalla extends \common\models\MyActiveRecord
{
    
    public $tallaColor;
    public $precio;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producto_talla';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'talla_id', 'codigo_color', 'cantidad'], 'required'],
            [['producto_id', 'talla_id', 'cantidad', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['codigo_color'], 'string', 'max' => 10],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['producto_id' => 'id']],
            [['talla_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talla::className(), 'targetAttribute' => ['talla_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'producto_id' => 'Producto ID',
            'talla_id' => 'Talla ID',
            'codigo_color' => 'Codigo Color',
            'cantidad' => 'Cantidad',
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
    public function getPrecio()
    {
        return $this->hasOne(Producto::className(), ['id' => 'producto_id'])->precio_pesos;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTalla()
    {
        return $this->hasOne(Talla::className(), ['id' => 'talla_id']);
    }
    
    
    public function afterFind() {
        parent::afterFind();
        
        $this->tallaColor = $this->talla->descripcion.'- <span class="glyphicon glyphicon-stop" style="color:'.$this->codigo_color.'"></span>';
    }
}
