<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Proveedor;
use Yii;
/**
 * ProveedorSearch represents the model behind the search form of `frontend\models\Proveedor`.
 */
class ProveedorSearch extends Proveedor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estado_id', 'creado_por', 'actualizado_por'], 'integer'],
            [['nombre', 'usuario_id','descripcion', 'identificacion_nit', 'creado_el', 'actualizado_el'], 'safe'],
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
    public function search($params,$esSolicitante = null)
    {
        $query = Proveedor::find()->innerJoinWith('creadoPor cc');
        if($esSolicitante){
            $query = $query->where(['proveedor.creado_por' => Yii::$app->user->id,'estado_id' => [2,3,4]]);
        }else{
            if(Yii::$app->user->can('r-administrador-jagao'))
            $query = $query;
            else if(Yii::$app->user->can('r-proveedor'))
            $query = $query->where(['proveedor.creado_por' => Yii::$app->user->id,'estado_id' => [2,3,4]]);
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
            'estado_id' => $this->estado_id,
            'creado_por' => $this->creado_por,
            'creado_el' => $this->creado_el,
            'actualizado_por' => $this->actualizado_por,
            'actualizado_el' => $this->actualizado_el,
        ]);
        
        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'identificacion_nit', $this->identificacion_nit])
            ->andFilterWhere(['like', 'cc.username', $this->usuario_id]);

        return $dataProvider;
    }
}
