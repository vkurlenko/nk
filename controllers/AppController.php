<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 04.06.2018
 * Time: 15:48
 */

namespace app\controllers;

use yii\web\Controller;
use yii\db\Query;
use app\modules\admin\models\Options;

class AppController extends Controller
{
    public $arr;

    public function printArray($arr = null){
        return '<pre>'.print_r($arr).'</pre>';
    }

    public static function log($text){
        $f = fopen('log.txt', 'a+');
        fwrite($f, time().': '.$text."\r\n");
    }

    public function formatDate($date = null){
        $month = ['', 'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];

        $d = explode('-', $date);

        return $d[2].' '.$month[intval($d[1])].', '.$d[0];
    }

    public static function getOption($option_name = null){
        if($option_name){
            $option = Options::find()->where(['name' => $option_name])->asArray()->one();
            return $option['value'];
        }
        return false;
    }

    /* удаление картинки */
    public function actionDeleteimg($page_id, $img_id, $model_name = null)
    {
        $model = 'app\modules\admin\models\\'.$this->upFirstLetter($model_name);

        if($model){
            $page = $model::find()
            ->where(['id' => $page_id])
            ->one();

            $images = $page->getImages();
            $del = false;

            foreach($images as $img){
                if($img->id == $img_id){
                    $del = $page->removeImage($img);
                }
            }

            return $del;
        }
        else
            return false;
    }

    /* параметры картинки */
    public function actionSetnameimg($page_id, $img_id, $model_name = null, $name = null, $role = null, $sort = null, $url1 = null, $active = null)
    {
        //'app\modules\admin\models\Pages'
        $model = 'app\modules\admin\models\\'.$this->upFirstLetter($model_name);
        if($model){

            $page = $model::find()->where(['id' => $page_id])->one();

            $images = $page->getImages();
            $save = false;

            foreach($images as $img){
                if($img->id == $img_id)
                    $save = $img->setName($name, $sort, $role, $url1, $active);
            }
            return $save;
        }
        else
            return false;

    }

    public static function upFirstLetter($str, $encoding = 'UTF-8')
    {
        return mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) . mb_substr($str, 1, null, $encoding);
    }


}