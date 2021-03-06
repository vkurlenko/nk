<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Brands;

/**
 * BrandsSearch represents the model behind the search form of `app\modules\admin\models\Brands`.
 */
class BrandsSearch extends Brands
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'city'], 'integer'],
            [['name', 'logo', 'text', 'active'], 'safe'],
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
        $query = Brands::find();

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
                unset($session['brand_city']);
            }
            else{
                $this->city = Yii::$app->request->get('city');
                $session->set('brand_city', $this->city);
            }
        }
        elseif(isset($session['brand_city']))
            $this->city = $session['brand_city'];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'city' => $this->city,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'active', $this->active]);

        return $dataProvider;
    }
}
