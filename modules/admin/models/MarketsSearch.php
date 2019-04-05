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
            [['id', 'scale', 'active', 'sort'], 'integer'],
            [['text', 'name', 'city', 'latitude', 'longitude'], 'safe'],
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
                // количество пунктов на странице
                'pageSize' => 1000,
            ],
            'sort'=> ['defaultOrder' => ['sort' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		$session = Yii::$app->session;
        if(Yii::$app->request->get('city')){
            if(Yii::$app->request->get('city') == 'all'){
                unset($session['market_city']);
            }
            else{
                $this->city = Yii::$app->request->get('city');
                $session->set('market_city', $this->city);
            }
        }
        elseif(isset($session['market_city']))
            $this->city = $session['market_city'];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'city' => $this->city,
        ]);

        // grid filtering conditions
        /*$query->andFilterWhere([
            'id' => $this->id,
            'name' => $this->name,
            'url_alias' => $this->url_alias,
            'city' => $this->city,
            'short_addr' => $this->short_addr,
            'scale' => $this->scale,
            'active' => $this->active,
            'sort' => $this->sort,
        ]);*/

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'longitude', $this->longitude]);

        return $dataProvider;
    }
}
