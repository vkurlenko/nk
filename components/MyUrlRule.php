<?php
namespace app\components;

use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use yii\helpers\Url;
use app\models\Pages;

class MyUrlRule extends BaseObject implements UrlRuleInterface
{
	public function createUrl($manager, $route, $params)
	{
		/*if($route === 'car/index'){
			if(isset($params['manufacturer'], $params['model'])){
				return $params['manufacturer'].'/'.$params['model'];				
			}
			elseif(isset($params['manufacturer'])){
				return $params['manufacturer'];
			}
		}*/
		return false;
	}
	
	public function parseRequest($manager, $request)
	{	
		// параметры запроса
		$params = explode('/', $request->getPathInfo());
		
		foreach($params as $index => $value){
			if(!$value)
				unset($params[$index]);
		}
		
		// если не модуль admin
		if($params[0] != 'admin'){				
			
			$get = []; // 
			$arr = []; // 
			
			// параметры страницы по ее URL
			$page_data = Pages::find()->where(['url' => $params[0]])->asArray()->one();		

			// все параметры запроса, кроме 0-го будем считать GET параметрами
			$get = array_slice($params, 1);
			//debug($get);
			
			// по шаблону страницы определим ее контроллер
			if($page_data['tpl'] && $page_data['tpl'] != 'text'){
				$controller = $page_data['tpl'];
				$action = 'index';
			}
			// если шаблон не определен, то применим шаблон текстовой страницы
			else{
				$controller = 'site';
				$action = 'text';
			}
			
			// в зависимости от контроллера сформируем массив GET параметров,
			// которые передадим в контроллер
			if($controller == 'where' ){
				$arr['city'] = $get[0];
			}
				
			if(isset($controller, $action))
				return [$controller.'/'.$action, $arr];
			else
				return false;
		}
		return false;
				
		//'gde' => 'where/index',
		//'gde/<city:[a-z0-9_\-()]+>' => 'where/index',
		
		//return false;
	}	
}