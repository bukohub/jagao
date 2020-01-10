<?php

namespace frontend\models;

use Yii;
use common\models\User;
use backend\models\AuthAssignment;

/**
 * This is the model class for table "resultado_revision_proveedor".
 *
 * @property int $id
 * @property string $resultado
 * @property int $proveedor_id
 * @property string $observacion
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property Proveedor $proveedor
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class ResultadoRevisionProveedor extends \common\models\MyActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'resultado_revision_proveedor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['resultado', 'proveedor_id'], 'required'],
            [['resultado', 'observacion'], 'string'],
            [['proveedor_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedor::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'resultado' => 'Resultado',
            'proveedor_id' => 'Proveedor ID',
            'observacion' => 'Observacion',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedor() {
        return $this->hasOne(Proveedor::className(), ['id' => 'proveedor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreadoPor() {
        return $this->hasOne(User::className(), ['id' => 'creado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActualizadoPor() {
        return $this->hasOne(User::className(), ['id' => 'actualizado_por']);
    }

    public function estadoAprobado() {
        $proveedor = Proveedor::findOne($this->proveedor_id);
        $proveedor->estado_id = 1;
        $proveedor->save();
        $tieneRol = AuthAssignment::find()->where(['user_id' => $proveedor->creado_por,'item_name' => 'r-proveedor'])->one();
        $tieneRolSolicitud = AuthAssignment::find()->where(['user_id' => $proveedor->creado_por,'item_name' => 'r-solicitante-proveedor'])->one();
        if(!empty($tieneRolSolicitud)){
            $tieneRolSolicitud->delete();
        }
        
        if (empty($tieneRol)) {
            $asignarPermiso = new AuthAssignment();
            $asignarPermiso->user_id = $proveedor->creado_por;
            $asignarPermiso->item_name = 'r-proveedor';
            if (!$asignarPermiso->save()) {
                print_r($asignarPermiso->getErrors());
                die();
            }
        }
    }

    public function estadoRechazado() {
        $proveedor = Proveedor::findOne($this->proveedor_id);
        $proveedor->estado_id = 2;
        $proveedor->save();
    }

    
    /*public function estadoDevuelto() {
        $proveedor = Proveedor::findOne($this->proveedor_id);
        $proveedor->estado_id = 3;
        $proveedor->save();
    }*/

}
