<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 12.02.2019
 * Time: 19:46
 */

namespace app\controllers;

use app\modules\admin\models\MarketsCities;
use Yii;
use app\models\Pages;
use app\modules\admin\models\Markets;



class WhereController  extends AppController
{
    public function actionIndex(){

        // определим данные главной страницы по ее url
        $page_data = \app\controllers\SiteController::getPageDataByUrl();

        if(!$page_data['active'])
            return $this->redirect(['site/index']);

        if($page_data){
            // найдем главную картинку и галерею картинок, если они прикреплены к странице
            $page = Pages::findOne($page_data['id']);
        }

        // выберем все торговые точки для карты
        if(Yii::$app->request->get('city')){
            $city = Yii::$app->request->get('city');
            //echo $city;
            $points = self::getMarkets($city);
        }
        else
            $points = self::getMarkets();

        // выберем все торговые точки для списка
        $markets = self::getMarketsList();

        // выберем города для выпадающего списка
        $cities = self::getCities();

        return $this->render('where', compact('page_data', 'points', 'markets', 'cities'));

    }

    public static function getMarkets($city_alias = null)
    {
        if($city_alias && $city_alias != 'all'){

           /* if($city_alias == 'moscow'){
                $arr_city = MarketsCities::find()
                            ->where(['url_alias' => $city_alias, 'active' => true])
                            ->orWhere(['is_region' => true])
                            ->asArray()
                            ->all();
            }
            else*/
                $arr_city[] = MarketsCities::find()
                            ->where(['url_alias' => $city_alias, 'active' => true])
                            ->asArray()
                            ->one();

            if($arr_city){
                $res = [];
                foreach($arr_city as $city_data){
                    $city = $city_data['city'];

                    $arr = Markets::find()
							->where(['city' => $city, 'active' => true])
							->orderBy(['sort' => SORT_ASC])
							->asArray()
							->all();

                    $res = array_merge ($res, $arr);
                }
            }
         }
        else
            $res = Markets::find()
                    ->where(['active' => true])
					->orderBy(['sort' => SORT_ASC])
					->asArray()
					->all();


            foreach($res as $index => $market){
                if(!self::checkCityActive($market['city'])){
                    unset($res[$index]);
                }
            }

        //debug($res); die;

        return $res;
    }

    /**
     * проверим активность города
     */
    public static function checkCityActive($city = null)
    {
        $res = false;

        if($city){
            $res = MarketsCities::find()
                ->where(['city' => $city, 'active' => true])
                ->asArray()
                ->one();
        }

        return $res;
    }

    public function getCities()
    {
        // все города Где купить, кроме МО
        $cities = MarketsCities::find()
					//->where(['is_region' => false, 'active' => true])
					->where(['active' => true])
					->orderBy(['first' => SORT_DESC, 'city' => SORT_ASC])
					->asArray()
					->all();
					
		//debug($cities);
	
		foreach($cities as $index => $city){
		
			/*if($city['url_alias'] = 'moscow'){
				$markets = Markets::find()
						->where(['active' => true, 'city' => $city['city']])
						->orWhere(['active' => true, 'is_region' => true])
						->orderBy(['sort' => SORT_ASC])
						->asArray()
						->indexBy('city')
						->all();
			}
			else{*/
				$markets = Markets::find()
						->where(['active' => true, 'city' => $city['city']])
						->orderBy(['sort' => SORT_ASC])
						->asArray()
						->indexBy('city')
						->all(); 			
			//}		
			
			if(!$markets){
				unset($cities[$index]);
			}
		}
		
				//debug($cities);

        return $cities;
    }

    /**
     * сформируем массив торговых точек по городам     *
     */
	public function getMarketsList()
    {
        // все города Где купить
        $cities = MarketsCities::find()
					//->where(['is_region' => false, 'active' => true])
					//->orWhere(['url_alias' => 'moscow', 'active' => true])
					//->orderBy(['sort' => SORT_ASC])
					->where(['active' => true])
					->orderBy(['first' => SORT_DESC, 'city' => SORT_ASC])
					->asArray()
					->all();

        // все города Где купить из МО
        /*$region = MarketsCities::find()
					->where(['is_region' => true, 'active' => true])
					->orderBy(['sort' => SORT_ASC])
					->asArray()
					->all();*/

        // все точки Где купить
        $markets = Markets::find()
					->where(['active' => true])
					//->orWhere(['city' => 'Москва']) // в любом случае включаем Москву чтобы показать точки в области
					->orderBy(['sort' => SORT_ASC])
					->asArray()
					->indexBy('city')
					->all();

					
       

        foreach($cities as $index => $city){

            // выберем точки для данного города
            if($markets[$city['city']]){
                $cities[$index]['markets'] = Markets::find()
											->where(['city' => $city['city'], 'active' => true])
											->orderBy(['sort' => SORT_ASC])
											->asArray()
											->all();
            }
			else{
				// если в городе нет точек, то удалим его из массива городов
				unset($cities[$index]);
			}

            // для Москвы добавим точки из подмосковья
            /*if($city['city'] == 'Москва'){
                foreach($region as $reg_city){

                    $arr = Markets::find()
							->where(['city' => $reg_city['city'], 'active' => true])
							->orderBy(['sort' => SORT_ASC])
							->asArray()
							->all();

                    if($arr){
                        foreach($arr as $k => $v){
                            $arr[$k]['name'] = $v['city'].' '.$v['name'];
                        }

                        if(!$cities[$index]['markets'])
                            $cities[$index]['markets'] = [];

                        $cities[$index]['markets'] = array_merge ($cities[$index]['markets'], $arr);
                    }
                }
            }*/
        }
		
		/*
		debug($cities); 
		debug($markets);		
		die;
		*/
		//debug($cities); die;
		
        return $cities;
    }
}