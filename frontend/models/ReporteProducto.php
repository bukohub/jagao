<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "reporte_producto".
 *
 * @property int $id
 * @property int $tipo_reporte_producto_id
 * @property string $descripcion
 * @property int $producto_id
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property Producto $producto
 * @property TipoReporteProducto $tipoReporteProducto
 */
class ReporteProducto extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reporte_producto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_reporte_producto_id', 'descripcion', 'producto_id'], 'required'],
            [['tipo_reporte_producto_id', 'producto_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['descripcion'], 'string'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['producto_id' => 'id']],
            [['tipo_reporte_producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoReporteProducto::className(), 'targetAttribute' => ['tipo_reporte_producto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_reporte_producto_id' => 'Tipo de reporte',
            'descripcion' => 'Descripción',
            'producto_id' => 'Producto ID',
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
    public function getTipoReporteProducto()
    {
        return $this->hasOne(TipoReporteProducto::className(), ['id' => 'tipo_reporte_producto_id']);
    }
}
