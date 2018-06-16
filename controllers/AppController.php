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
}