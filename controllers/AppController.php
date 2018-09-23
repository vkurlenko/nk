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

    public function actionDeleteOneImg($page_id, $field = null, $model_name = null)
    {
        $model = 'app\modules\admin\models\\'.$this->upFirstLetter($model_name);

        if($model && $field){
            $page = $model::find()
                ->where(['id' => $page_id])
                ->one();

            $del = false;

            $arr = unserialize($page->$field);

            $page->$field = '';
            $del = $page->update();

            if($arr['src'] && file_exists($_SERVER['DOCUMENT_ROOT'].'/web'.$arr['src']))
                unlink($_SERVER['DOCUMENT_ROOT'].'/web'.$arr['src']);

            return $del;
        }
        else
            return false;
    }

    public function actionSetCheckbox($model_name = null, $field = null, $id = null,  $status = null){
        $model = 'app\modules\admin\models\\'.$this->upFirstLetter($model_name);



        if($model && $field && $id){
            $attr = $model::find()
                ->where(['id' => $id])
                ->one();

            $save = false;

            //$status = $status ? 1 : 0;

            /*if($status == 'true')
                $s = 1;
            else
                $s = 0;*/

            //return $s;

            $attr->$field = $status;
            //return $attr->$field;

            $save = $attr->update();

            return $save;
        }
        else
            return false;

    }



    public static function upFirstLetter($str, $encoding = 'UTF-8')
    {
        return mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) . mb_substr($str, 1, null, $encoding);
    }

    public static function yaTranslit($string){
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'yo',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'kh',   'ц' => 'ts',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '',     'ы' => 'y',   'ъ' => '',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'Yo',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'Kh',   'Ц' => 'Ts',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );

        $translit = strtr($string, $converter);

        $translit = strtolower($translit);

        // заменям все ненужное нам на "-"
        $translit = preg_replace('~[^-a-z0-9_]+~u', '-', $translit);

        // удаляем начальные и конечные '-'
        $translit = trim($translit, "-");

        return $translit;
    }

    public function makePrettyUrl($string = null, $model_name = null){

        $model = 'app\modules\admin\models\\'.$this->upFirstLetter($model_name);

        $url = AppController::yaTranslit($string);
        $url_alias = $model::find()->where(['LIKE', 'url_alias', [$url]])->all();
//debug($url_alias);
        if($url_alias){
            $url .= '-'. count($url_alias);
        }

        return $url;
    }

    /*public static function getVersion(){
        $version = Options::find('value')->where(['name' => 'version'])->one();
        return $version;
    }*/


}