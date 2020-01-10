<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PreguntaProducto;
use Yii;

/**
 * PreguntaProductoSearch represents the model behind the search form of `frontend\models\PreguntaProducto`.
 */
class PreguntaProductoSearch extends PreguntaProducto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estado_pregunta_id', 'actualizado_por'], 'integer'],
            [['descripcion','producto_id', 'creado_por', 'creado_el', 'actualizado_el'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$me = TRUE)
    {
        $query       = PreguntaProducto::find()->joinWith('producto p')->innerJoinWith("creadoPor cc");;

        if ($me){
            $get_prov_id =  Proveedor::find()->where(['usuario_id' => Yii::$app->user->id])->one();
        
            if(!empty($get_prov_id))
            $query->where(['proveedor_id' =>  $get_prov_id->id]);               
        
        }else{
            $query->where(['pregunta_producto.creado_por'=>Yii::$app->user->id]);
        }
       
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');    
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'estado_pregunta_id' => $this->estado_pregunta_id,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);
        $query->andFilterWhere(['like', 'p.nombre', $this->producto_id]);
        $query->andFilterWhere(['like', 'cc.username', $this->creado_por]);
        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
