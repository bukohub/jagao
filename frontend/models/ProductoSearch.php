<?php

namespace frontend\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Producto;

/**
 * ProductoSearch represents the model behind the search form of `frontend\models\Producto`.
 */
class ProductoSearch extends Producto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cantidad_stock', 'proveedor_id', 'estado_producto_id', 'calificacion_promedio', 'creado_por', 'actualizado_por'], 'integer'],
            [['nombre', 'descripcion', 'creado_el', 'actualizado_el'], 'safe'],
            [['precio_pesos'], 'number'],
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
    public function search($params)
    {
        $query = Producto::find();
        // add conditions that should always apply here
        if(Yii::$app->user->can('r-proveedor')){
            $get_prov_id =  Proveedor::find()->where(['usuario_id' => Yii::$app->user->id])->one();
            if(!empty($get_prov_id))
                $query->where(['proveedor_id' =>  $get_prov_id->id]);
        }else if(!Yii::$app->user->can('r-administrador-jagao')){
            $query->where(['user_id' =>  Yii::$app->user->id]);
        }



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
            'cantidad_stock' => $this->cantidad_stock,
            'precio_pesos' => $this->precio_pesos,
            'proveedor_id' => $this->proveedor_id,
            'estado_producto_id' => $this->estado_producto_id,
            'calificacion_promedio' => $this->calificacion_promedio,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
