<?php

namespace frontend\models;
use Yii;
use common\models\User; 
/**
* This is the model class for table "informacion_compra".
*
* @property string $id
* @property int $id_compra 
* @property string $nombre
* @property string $apellido
* @property int $cedula
 
* @property string $actualizado_por
* @property string $actualizado_el
*
* @property ProductoCompras $compra 
* @property User $creadoPor
* @property User $actualizadoPor
* @property Pais $pais
* @property Municipio $ciudad
* @property EstadoDepartamento $depto
*/
class InformacionCompra extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'informacion_compra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido', 'cedula', 'direccion', 'id_pais', 'id_depto', 'id_ciudad', 'telefono', 'email'], 'required'],
            [['cedula', 'id_pais', 'id_depto', 'id_ciudad', 'telefono', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['nombre', 'apellido', 'email'], 'string', 'max' => 250],
            [['direccion'], 'string', 'max' => 300],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['id_pais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['id_pais' => 'id']],
            [['id_ciudad'], 'exist', 'skipOnError' => true, 'targetClass' => Municipio::className(), 'targetAttribute' => ['id_ciudad' => 'id']],
            [['id_depto'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoDepartamento::className(), 'targetAttribute' => ['id_depto' => 'id']],
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
            'apellido' => 'Apellido',
            'cedula' => 'Cédula',
            'direccion' => 'Dirección',
            'id_pais' => 'Pais',
            'id_depto' => 'Departamento',
            'id_ciudad' => 'Ciudad',
            'telefono' => 'Teléfono',
            'email' => 'Email',
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
    public function getPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'id_pais']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiudad()
    {
        return $this->hasOne(Municipio::className(), ['id' => 'id_ciudad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepto()
    {
        return $this->hasOne(EstadoDepartamento::className(), ['id' => 'id_depto']);
    }
}
