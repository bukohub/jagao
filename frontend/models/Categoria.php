<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "categoria".
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $estado
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property ProductoCategoria[] $productoCategorias
 * @property ResultadoRevisionCategoria[] $resultadoRevisionCategorias
 */
class Categoria extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion', 'estado'], 'required'],
            [['descripcion', 'estado'], 'string'],
            [['creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre'], 'string', 'max' => 250],
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
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
            'estado' => 'Estado',
            'creado_por' => 'Creado por',
            'creado_el' => 'Fecha de creación',
            'actualizado_por' => 'Actualizado por',
            'actualizado_el' => 'Fecha de la ultima actualización',
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
    public function getProductoCategorias()
    {
        return $this->hasMany(ProductoCategoria::className(), ['categoria_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultadoRevisionCategorias()
    {
        return $this->hasMany(ResultadoRevisionCategoria::className(), ['categoria_id' => 'id']);
    }
}
