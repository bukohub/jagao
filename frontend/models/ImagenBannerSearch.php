<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ImagenBanner;

/**
 * ImagenBannerSearch represents the model behind the search form of `\frontend\models\ImagenBanner`.
 */
class ImagenBannerSearch extends ImagenBanner
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'creado_por', 'actualizado_por'], 'integer'],
            [['descripcion_principal', 'descripcion_secundaria', 'nombre_archivo_original', 'nombre_archivo', 'ruta_archivo', 'creado_el', 'actualizado_el'], 'safe'],
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
        $query = ImagenBanner::find();

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
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);

        $query->andFilterWhere(['like', 'descripcion_principal', $this->descripcion_principal])
            ->andFilterWhere(['like', 'descripcion_secundaria', $this->descripcion_secundaria])
            ->andFilterWhere(['like', 'nombre_archivo_original', $this->nombre_archivo_original])
            ->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'ruta_archivo', $this->ruta_archivo]);

        return $dataProvider;
    }
}
