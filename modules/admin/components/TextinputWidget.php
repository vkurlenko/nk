<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16.02.2019
 * Time: 21:36
 */

namespace app\modules\admin\components;

use yii\base\Widget;

class TextinputWidget  extends Widget
{
    public $option_name;
    public $model_name = 'options';
    public $class_name;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $model_name = $this->model_name;
        $option_name = $this->option_name;
        $class_name = $this->class_name;


        $data = \app\controllers\AppController::getOptionData($option_name);
        //debug($data);
        $data = (object)$data;
        $attr = 'value';
        $title = $data->comment.' ';


        return $this->render('textinput', compact('data', 'model_name', 'attr', 'title', 'class_name'));

    }
}
