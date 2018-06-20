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

class AppController extends Controller
{
    public $arr;

    public function printArray($arr = null){
        return '<pre>'.print_r($arr).'</pre>';
    }

    public function formatDate($date = null){
        $month = ['', 'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];

        $d = explode('-', $date);

        return $d[2].' '.$month[intval($d[1])].', '.$d[0];
    }
}