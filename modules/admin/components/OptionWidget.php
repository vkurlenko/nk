<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 08.07.2018
 * Time: 00:54
 */

namespace app\modules\admin\components;


use yii\base\Widget;

class OptionWidget extends Widget
{
    public $option_name;
	public $model_name = 'options';

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $model_name = $this->model_name;
        $option_name = $this->option_name;
		
		$data = \app\controllers\AppController::getOptionData($option_name);
		$data = (object)$data;
		$attr = 'value';
		$title = $data->comment.' ';
       
        return $this->render('checkbox', compact('data', 'model_name', 'attr', 'title'));

    }
}