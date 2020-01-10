<?php

namespace common\models;

use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Clase con BlameableBehavior y TimestampBehavior que permite guardar
 * los datos de auditoría a todos los modelos que extienden de esta clase
 * 
 * @author Brian Cardona Salazar <brian.cardonas@autonoma.edu.co>
 * @author Lina María Ocampo Cuartas <lina.ocampo@autonoma.edu.co>
 */
class MyActiveRecord extends ActiveRecord {

    public function behaviors() {
        $arrayBehaviors = [];
        
        if($this->attributes('creado_por') && $this->attributes('actualizado_por')){
            $arrayBehaviors['blameable'] = [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'creado_por',
                'updatedByAttribute' => 'actualizado_por',
            ];          
        }
        
        if($this->attributes('creado_el') && $this->attributes('actualizado_el')){
            $arrayBehaviors['timestamp'] = [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['creado_el', 'actualizado_el'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['actualizado_el'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ];          
        }
            
        return $arrayBehaviors;
    }        
    
}
