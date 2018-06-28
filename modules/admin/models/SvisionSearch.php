<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Svision;

/**
 * SvisionSearch represents the model behind the search form of `app\modules\admin\models\Svision`.
 */
class SvisionSearch extends Svision
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'person_id', 'size', 'active'], 'integer'],
            [['date', 'title', 'descr', 'video'], 'safe'],
            [['type'], 'string'],
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
        $query = Svision::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['date' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $type = 'svision';
        if(Yii::$app->request->get('type'))
            $type = Yii::$app->request->get('type');

        $query->andFilterWhere([
            'id' => $this->id,
            'person_id' => $this->person_id,
            'date' => $this->date,
            'size' => $this->size,
            'type' => $type,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'descr', $this->descr])
            ->andFilterWhere(['like', 'video', $this->video]);

        return $dataProvider;
    }
}
