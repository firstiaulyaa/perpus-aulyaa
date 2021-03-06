<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KenaikanDenda;

/**
 * KenaikanDendaSearch represents the model behind the search form of `app\models\KenaikanDenda`.
 */
class KenaikanDendaSearch extends KenaikanDenda
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'hari'], 'integer'],
            [['harga'], 'number'],
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
        $query = KenaikanDenda::find();

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
            'hari' => $this->hari,
            'harga' => $this->harga,
        ]);

        return $dataProvider;
    }
}
