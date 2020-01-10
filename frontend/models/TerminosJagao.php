<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "terminos_jagao".
 *
 * @property int $id
 * @property string $texto_terminos_contrato
 * @property string $texto_politica_datos
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $actualizadoPor
 * @property User $creadoPor
 */
class TerminosJagao extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'terminos_jagao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['texto_terminos_contrato', 'texto_politica_datos'], 'required'],
            [['texto_terminos_contrato', 'texto_politica_datos'], 'string'],
            [['creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['creado_por'], 'unique'],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'texto_terminos_contrato' => 'Texto Terminos Contrato',
            'texto_politica_datos' => 'Texto Politica Datos',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
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
}
