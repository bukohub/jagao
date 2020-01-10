<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\DireccionCliente;
use Yii;

/**
 * DireccionClienteSearch represents the model behind the search form of `frontend\models\DireccionCliente`.
 */
class DireccionClienteSearch extends DireccionCliente
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pais_id', 'departamento_estado_id', 'usuario_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['ciudad', 'detalle', 'creado_el', 'actualizado_el'], 'safe'],
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
        $query = DireccionCliente::find();

        if(!Yii::$app->user->can('r-administrador-jagao')){
            $query->andFilterWhere(['usuario_id'=>Yii::$app->user->id]);
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
            'pais_id' => $this->pais_id,
            'departamento_estado_id' => $this->departamento_estado_id,
            'usuario_id' => $this->usuario_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'ciudad', $this->ciudad])
            ->andFilterWhere(['like', 'detalle', $this->detalle]);

        return $dataProvider;
    }
}
