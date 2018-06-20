<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19.06.2018
 * Time: 11:25
 */

namespace app\controllers;

use Yii;
use app\modules\admin\models\Persons;
use app\modules\admin\models\Cities;
use app\modules\admin\models\Svision;

class PersonController extends AppController
{
    public $person;
    public $photos;
    public $s_video;

    // если есть ID участника ($_GET['id'])
    public function actionIndex(){

        if(Yii::$app->request->get('id')){
            $id = Yii::$app->request->get('id');
            $person = $this->getPerson($id);
            $s_video = $this->getSvision($id, 'svision');
            $video = $this->getSvision($id, 'video');
            $person_nav['prev'] = $this->getNavPerson($id, 'prev');
            $person_nav['next'] = $this->getNavPerson($id, 'next');
        }

        return $this->render('index', compact('person', 's_video', 'video', 'person_nav'));
    }

    // если нет ID участника, то выводим всех
    public function actionPerson(){

        $persons = [];
        $cities = Cities::find()->select(['id'])->where(['active' => '1'])->asArray()->orderBy(['sort' => SORT_ASC])->all();

        //debug($cities);

        $years = Persons::find()->select(['year'], 'DISTINCT')->where(['active' => 1])->asArray()->orderBy(['year' => SORT_DESC])->all();

        if(Yii::$app->request->get('year')){
            $year = Yii::$app->request->get('year');
        }

        foreach($cities as $k => $v){
            $persons[] = $this->getPersons($v, $year);
        }

        return $this->render('persons', compact(['persons', 'years']));
    }

    // получим данные всех участников
    public function getPersons($city = null, $year = null){

        $arr = [];

        $where = [
            'active' => 1,
        ];

        if($city)
            $where['city_id'] = $city;

        if($year)
            $where['year'] = $year;

        $persons = Persons::find()->where($where)->asArray()->orderBy(['year' => SORT_DESC])->all();

        foreach($persons as $person){
            if($person['city_id'])
                $person['city_id'] = $this->getCity($person['city_id']);

            $photos = $this->getPhotos($person['id']);

            foreach($photos as $photo => $url){
                $person[$photo] = $url;
            }

            $arr[] = $person;
        }

        return $arr;
    }

    // получим данные участика по его ID
   public function getPerson($id = null){

       $person = Persons::findOne($id);

       if($person->city_id)
           $person->city_id = $this->getCity($person->city_id);

       $photos = $this->getPhotos($id);

       foreach($photos as $photo => $url){
           $person[$photo] = $url;
       }

       return $person;
    }

    public function getNavPerson($id = null, $dir = null){

        $person = $this->getPerson($id);

        if($person && $dir){
            switch($dir){
                case 'prev' :
                    $nav_person = Persons::find()
                        ->andWhere('sort < :sort_this', [':sort_this' => $person->sort])
                        ->andWhere('year = :year_this', [':year_this' => $person->year])
                        ->orderBy(['year' => SORT_DESC, 'sort' => SORT_DESC])
                        ->asArray()
                        ->one();

                    if(!$nav_person)
                        $nav_person = Persons::find()
                            //->andWhere('sort > :sort_this', [':sort_this' => $person->sort])
                            ->andWhere('year = :year_this', [':year_this' => $person->year + 1])
                            ->orderBy(['year' => SORT_DESC, 'sort' => SORT_DESC])
                            ->asArray()
                            ->one();
                    break;

                case 'next' :
                    $nav_person = Persons::find()
                        ->andWhere('sort > :sort_this', [':sort_this' => $person->sort])
                        ->andWhere('year = :year_this', [':year_this' => $person->year])
                        ->orderBy(['year' => SORT_DESC, 'sort' => SORT_ASC])
                        ->asArray()
                        ->one();

                    if(!$nav_person)
                        $nav_person = Persons::find()
                            //->andWhere('sort < :sort_this', [':sort_this' => $person->sort])
                            ->andWhere('year = :year_this', [':year_this' => $person->year - 1])
                            ->orderBy(['year' => SORT_DESC, 'sort' => SORT_ASC])
                            ->asArray()
                            ->one();
                    break;

                default: break;
            }

            return $nav_person['id'];
        }
        else
            return false;
    }

    // ID города -> название города
    public function getCity($city_id = null){

        $city = Cities::findOne($city_id);

        return $city->city;
    }

    // получим все записи авторского надзора участника по его ID
    public function getSvision($id = null, $type = 'svision'){

        $arr_video = Svision::find()->where(['active' => 1, 'person_id' => $id, 'type' => $type])->orderBy(['date' => SORT_DESC])->asArray()->all();

        $i = 0;
        foreach($arr_video as $video){
            $j = 0;
            foreach($video as $k => $v){
                if($k == 'video'){
                    $sl = strrpos($v, '/');
                    if($sl){
                        $arr_video[$i]['video'] = substr($v, $sl+1);
                        $arr_video[$i]['cover'] = $this->getPhoto($arr_video[$i]['id']);
                    }

                    $arr_video[$i]['date'] = $this->formatDate($arr_video[$i]['date']);

                }
                $j++;
            }
            $i++;
        }

        return $arr_video;
    }

    public function formatDate($date = null){
        $month = ['', 'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];

        $d = explode('-', $date);

        return $d[2].' '.$month[intval($d[1])].', '.$d[0];
    }

    // получим обложку видео Авторского надзора
    public function getPhoto($id = null){


        $model = Svision::findOne($id);
        $cover = $model->getImage();

        return $cover->getUrl('660x377');
    }

    // получим фото участника
    public function getPhotos($id = null){

        $photos = [];
        $model = Persons::findOne($id);
        $images = $model->getImages();

        $pfx = 'photo';
        foreach($images as $img){
            switch($img->role){
                case $pfx.'_big'   :
                    $photos[$pfx.'_big'] = [$img->getUrl('350x534'), $img->name]; break;

                case $pfx.'_small' :
                    $photos[$pfx.'_small'] = [$img->getUrl('350x197'), $img->name]; break;

                case $pfx.'_cake'  :
                    $photos[$pfx.'_cake'] = [$img->getUrl('350x327'), $img->name]; break;

                case $pfx.'_on_main'  :
                    $photos[$pfx.'_on_main'] = [$img->getUrl('338x235'), $img->name]; break;

                default : break;
            }
        }

        return $photos;
    }




}