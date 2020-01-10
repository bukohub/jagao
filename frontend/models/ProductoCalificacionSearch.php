<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ProductoCalificacion;
use Yii;

/**
 * ProductoCalificacionSearch represents the model behind the search form of `\frontend\models\ProductoCalificacion`.
 */
class ProductoCalificacionSearch extends ProductoCalificacion
{
    public $creado_el_rango;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'actualizado_por'], 'integer'],
            [['calificacion','creado_por','producto_id','creado_el_rango', 'creado_el', 'actualizado_el'], 'safe'],
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



    public function searchMe($params){
        $query = ProductoCalificacion::find()->select("*")->innerJoinWith("creadoPor cc");
        $query->joinWith("productoCompras pc",true , 'RIGHT JOIN')->where(['pc.user_id'=>Yii::$app->user->id,'calificacion' => null,'pc.estado_id'=>1]);
        return $this->search($params,$query);
    }

    public function searchIndex($params){
        $query = ProductoCalificacion::find()->joinWith("creadoPor cc");
        $query->joinWith("productoCompras pc",true , 'RIGHT JOIN')->where(['pc.estado_id'=>1,'pc.user_id'=>Yii::$app->user->id])->andWhere(['not', ['calificacion' => null]]);
        return $this->search($params,$query);
    }

    public function searchCalificaciones($params){
        if(Yii::$app->user->can('r-proveedor') or Yii::$app->user->can('r-administrador-jagao')){
        $query = ProductoCalificacion::find()->innerJoinWith("producto p")->innerJoinWith("creadoPor cc")->joinWith("productoCompras pc",true , 'LEFT JOIN');
        
            if(Yii::$app->user->can('r-proveedor')){
                $get_prov_id =  Proveedor::find()->where(['usuario_id' => Yii::$app->user->id])->one();
                $prov_in     =  !empty($get_prov_id) ?  $get_prov_id->id : NULL;
                $query->andFilterWhere(['p.proveedor_id' => $prov_in]);
            }
            return $this->search($params,$query);
        }
       
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$query)
    {
        /*$query = ProductoCalificacion::find()->select("producto_calificacion.*,p.*")->innerJoinWith("producto p")->joinWith("creadoPor cc");
        
        //Si no es mi vista
        if(!$me){
            
            if(Yii::$app->user->can('r-proveedor') and $proveedor){
                
                $get_prov_id =  Proveedor::find()->where(['usuario_id' => Yii::$app->user->id])->one();
                $prov_in     =  !empty($get_prov_id) ?  $get_prov_id->id : NULL;
                $query->andFilterWhere(['p.proveedor_id' => $prov_in]);
                
            }else if(!Yii::$app->user->can('r-administrador-jagao')){

                $query->joinWith("productoCompras pc",true , 'RIGHT JOIN')->where(['pc.estado_id'=>1,'pc.user_id'=>Yii::$app->user->id])->andWhere(['not', ['calificacion' => null]]);

            }

        }else{

            $query->joinWith("productoCompras pc",true , 'RIGHT JOIN')->where(['pc.user_id'=>Yii::$app->user->id,'calificacion' => null,'pc.estado_id'=>1]);

        }*/
        $query = $query;


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
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);
        
        if(!empty($this->creado_el_rango) && strpos($this->creado_el_rango, '-') !== false) {
			list($start_date, $end_date) = explode(' - ', $this->creado_el_rango);
			$query->andFilterWhere(['between', 'producto_calificacion.creado_el', date("Y-m-d h:i:s",strtotime($start_date)),date("Y-m-d h:i:s", strtotime($end_date))]);
        }	
        
        $query->andFilterWhere(['like', 'pc.descripcion', $this->producto_id]);
        $query->andFilterWhere(['like', 'cc.username', $this->creado_por]);
        $query->andFilterWhere(['like', 'calificacion', $this->calificacion]);

        return $dataProvider;
    }
}
