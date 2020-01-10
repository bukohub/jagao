<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "resultado_revision_categoria".
 *
 * @property int $id
 * @property string $resultado
 * @property string $observacion
 * @property int $categoria_id
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property Categoria $categoria
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class ResultadoRevisionCategoria extends \common\models\MyActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resultado_revision_categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resultado', 'categoria_id'], 'required'],
            [['resultado', 'observacion'], 'string'],
            [['categoria_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
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
            'resultado' => 'Resultado',
            'observacion' => 'Observacion',
            'categoria_id' => 'Categoria ID',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id']);
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
    
    public function estadoAprobado() {
        $categoria = Categoria::findOne($this->categoria_id);
        $categoria->estado = 'Activo';
        $categoria->save();
    }

    public function estadoRechazado() {
        $categoria = Categoria::findOne($this->categoria_id);
        $categoria->estado = 'Rechazo';
        $categoria->save();
    }

    public function estadoDevuelto() {
        $categoria = Categoria::findOne($this->categoria_id);
        $categoria->estado = 'Devuelto';
        $categoria->save();
    }
}
