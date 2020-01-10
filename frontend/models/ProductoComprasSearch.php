<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ProductoCompras;
use Yii;

/**
 * ProductoComprasSearch represents the model behind the search form of `\frontend\models\ProductoCompras`.
 */
class ProductoComprasSearch extends ProductoCompras
{
    public $creado_el_rango; 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estado_id', 'creado_por','actualizado_por','cantidad','numero_guia','precio_costo','pago_proveedor'], 'integer'],
            [['descripcion','creado_el_rango','user_id','producto_id', 'actualizado_el','nombre_transportadora','codigo_factura','proveedor'], 'safe'],
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
    public function search($params, $me = TRUE)
    {
        $query = ProductoCompras::find()->innerJoinWith('producto pa')->innerJoinWith('proveedor pr')->innerJoinWith("user u")->innerJoinWith("estado ec")->andFilterWhere(['ec.id'=>1]);
        
        if(Yii::$app->user->can('r-proveedor') and $me){
            $get_prov_id =  Proveedor::find()->where(['usuario_id' => Yii::$app->user->id])->one();
            if(!empty($get_prov_id))  $query->andFilterWhere(['pa.proveedor_id' =>  $get_prov_id->id]);
        }else{
            if(!Yii::$app->user->can('r-administrador-jagao'))
            $query->andFilterWhere(['user_id' =>  Yii::$app->user->id]);
        }
        

        $query->orderBy(['producto_compras.id'=>SORT_DESC]);
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
            'producto_compras.id' => $this->id,
            'numero_guia' => $this->numero_guia,
            'producto_compras.estado_id' => $this->estado_id,
            'pago_proveedor'=>$this->pago_proveedor,
            'u.username' => $this->user_id,
            'creado_por' => $this->creado_por,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
            'pr.id'=> $this->proveedor
        ]);
        if(!empty($this->creado_el_rango) && strpos($this->creado_el_rango, '-') !== false) {
			list($start_date, $end_date) = explode(' - ', $this->creado_el_rango);
			$query->andFilterWhere(['between', 'producto_compras.creado_el', date("Y-m-d h:i:s",strtotime($start_date)),date("Y-m-d h:i:s", strtotime($end_date))]);
        }	
        $query->andFilterWhere(['like', 'producto.nombre', $this->producto_id]);
        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);
        $query->andFilterWhere(['like', 'codigo_factura', $this->codigo_factura]);
        return $dataProvider;
    }
}
