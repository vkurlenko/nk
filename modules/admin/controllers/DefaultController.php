<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Brands;
use app\modules\admin\models\Cities;
use app\modules\admin\models\PersonCities;
use app\modules\admin\models\Persons;

use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;
use app\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /*public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        debug ($model); die;
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }*/

    public static function getPersonCities(){
        $p_cities =  PersonCities::find()->select(['id', 'name'])->orderBy(['sort' => SORT_ASC])->asArray()->distinct()->all();

        return $p_cities;
    }



    public static function getPersonYearSubMenu(){
        $year = Persons::find()->select(['year'])->orderBy(['year' => SORT_DESC])->asArray()->distinct()->all();
        $arrPersonY = [];
        $session = Yii::$app->session;
        foreach($year as $y => $v){
            $arrOptions = [];

            if(isset($session['person_year']) && $session['person_year'] == $v['year'])
                $arrOptions = ['class' => 'active'];

            $n = Persons::find()->where(['year' => $v['year'], 'active' => 1])->count();
            $arrPersonY[] = ['label' => $v['year'].' ('.$n.')', 'icon' => '', 'options' => $arrOptions, 'url' => ['/admin/persons?year='.$v['year']]];
        }

        $n = Persons::find()->where(['active' => 1])->count();
        $arrPersonY[] = ['label' => 'Все ('.$n.')', 'icon' => '', 'options' => isset($session['person_year']) ? [] : ['class' => 'active'], 'url' => ['/admin/persons?year=all']];

        return $arrPersonY;
    }

    public static function getBrandsCitiesSubMenu(){
        $cities = Cities::find()->select(['id', 'city'])->orderBy(['sort' => SORT_ASC])->asArray()->distinct()->all();
        $arrCities = [];
        $session = Yii::$app->session;
        foreach($cities as $k => $v){
            $arrOptions = [];
            if(isset($session['brand_city']) && $session['brand_city'] == $v['id'])
                $arrOptions = ['class' => 'active'];

            $n = Brands::find()->where(['city' => $v['id'], 'active' => 1])->count();
            $arrCities[] = ['label' => $v['city'].' ('.$n.')', 'icon' => '', 'options' => $arrOptions, 'url' => ['/admin/brands?city='.$v['id']]];
        }
        $n = Brands::find()->where(['active' => 1])->count();
        $arrCities[] = ['label' => 'Все ('.$n.')', 'icon' => '', 'options' => isset($session['brand_city']) ? [] : ['class' => 'active'], 'url' => ['/admin/brands?city=all']];

        return $arrCities;
    }
}
