<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ReporteProducto;

/**
 * ReporteProductoSearch represents the model behind the search form of `frontend\models\ReporteProducto`.
 */
class ReporteProductoSearch extends ReporteProducto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipo_reporte_producto_id', 'actualizado_por'], 'integer'],
            [['descripcion','producto_id','creado_por', 'creado_el', 'actualizado_el'], 'safe'],
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
        $query = ReporteProducto::find()->innerJoinWith("producto p")->innerJoinWith("creadoPor cp");

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
            'tipo_reporte_producto_id' => $this->tipo_reporte_producto_id,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'p.nombre', $this->producto_id]);
        $query->andFilterWhere(['like', 'cp.name', $this->creado_por]);
        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
