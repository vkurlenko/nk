<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Persons;

/**
 * PersonsSearch represents the model behind the search form of `app\modules\admin\models\Persons`.
 */
class PersonsSearch extends Persons
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'city_id', 'year', 'winner', 'on_main', 'on_main_sort', 'active'], 'integer'],
            [['name', 'winner_text', 'text', 'photo_big', 'photo_small', 'photo_cake', 'photo_on_main'], 'safe'],
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
        $query = Persons::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1000,
            ],
            'sort'=> ['defaultOrder' => ['year' => SORT_DESC, 'sort' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
            'city_id' => $this->city_id,
            'year' => $this->year,
            'winner' => $this->winner,
            'on_main' => $this->on_main,
            'on_main_sort' => $this->on_main_sort,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'winner_text', $this->winner_text])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'photo_big', $this->photo_big])
            ->andFilterWhere(['like', 'photo_small', $this->photo_small])
            ->andFilterWhere(['like', 'photo_cake', $this->photo_cake])
            ->andFilterWhere(['like', 'photo_on_main', $this->photo_on_main]);

        return $dataProvider;
    }
}
