<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Citas;

/**
 * CitasSearch represents the model behind the search form of `app\models\Citas`.
 */
class CitasSearch extends Citas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id'], 'integer'],
            [['fecha', 'hora'], 'safe'],
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
        $query = Citas::find();

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

        // Filtro añadido para solo mostrar las citas del usuario logueado
        $query->andWhere([
            'usuario_id' => Yii::$app->user->id,
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
        ]);

        return $dataProvider;
    }
}
