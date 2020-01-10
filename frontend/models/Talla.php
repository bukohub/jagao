<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "talla".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property int $actualizado_el
 *
 * @property ProductoTalla[] $productoTallas
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class Talla extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'talla';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['creado_por', 'actualizado_por'], 'integer'],
            [['creado_el','actualizado_el'], 'safe'],
            [['descripcion'], 'string', 'max' => 10],
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
    public function getProductoTallas()
    {
        return $this->hasMany(ProductoTalla::className(), ['talla_id' => 'id']);
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
