<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Markets;

/**
 * MarketsSearch represents the model behind the search form of `app\modules\admin\models\Markets`.
 */
class MarketsSearch extends Markets
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'city', 'text'], 'integer'],
            [['brands', 'anons', 'active'], 'safe'],
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
        $query = Markets::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1000,
            ],
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
            'city' => $this->city,
            'text' => $this->text,
        ]);

        $query->andFilterWhere(['like', 'brands', $this->brands])
            ->andFilterWhere(['like', 'anons', $this->anons])
            ->andFilterWhere(['like', 'active', $this->active]);

        return $dataProvider;
    }
}
