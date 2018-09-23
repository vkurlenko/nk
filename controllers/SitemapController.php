<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19.08.2018
 * Time: 11:36
 */

namespace app\controllers;

use app\modules\admin\controllers\PagesController;
//use app\controllers\SiteController;
use app\modules\admin\models\Cities;
use app\modules\admin\models\Persons;
use app\modules\admin\models\Products;
use app\modules\admin\models\Svision;
use Yii;


class SitemapController extends AppController
{
    public function actionIndex()
    {

        Yii::$app->cache->delete('sitemap');
        if (!$xml_sitemap = Yii::$app->cache->get('sitemap')) {  // проверяем есть ли закэшированная версия sitemap

            $urls = array();

            /* страницы */
            $urls = array_merge($urls, self::getPages());

            /* лица проекта */
            $urls = array_merge($urls, self::getPersons());

            /* продукция */
            $urls = array_merge($urls, self::getProducts());

            /* где купить */
            $urls = array_merge($urls, self::getMarkets());

            $xml_sitemap = $this->renderPartial('index', array( // записываем view на переменную для последующего кэширования
                'host' => Yii::$app->request->hostInfo,         // текущий домен сайта
                'urls' => $urls,                                // с генерированные ссылки для sitemap
            ));

            Yii::$app->cache->set('sitemap', $xml_sitemap, 3600*12); // кэшируем результат, чтобы не нагружать сервер и не выполнять код при каждом запросе карты сайта.
        }

        //Yii::$app->response->format = \yii\web\Response::FORMAT_XML; // устанавливаем формат отдачи контента
        header("Content-Type: text/xml");
        echo $xml_sitemap;
        die;
        //Yii::$app->end();
    }

    public static function getPages(){
        $urls = [];

        $pages = PagesController::getAllPages();

        $tree = PagesController::mapTree($pages);

        if(!empty($tree)){
            foreach($tree as $row){
                $arr[$row['id']] = $row['title'];

                $urls[] = array(
                    Yii::$app->urlManager->createUrl(['/' . $row['url']]) // создаем ссылки на выбранные категории
                , 'daily'                                                           // вероятная частота изменения категории
                );

                if($row['childs']){
                    foreach($row['childs'] as $child){
                        $urls[] = array(
                            Yii::$app->urlManager->createUrl(['/' . $child['url']])
                        , 'daily'
                        );
                    }
                }
            }
        }
        return $urls;
    }

    public static function getPersons(){
        $urls = [];

        $persons = Persons::find()->where(['active' => 1,])->asArray()->orderBy(['year' => SORT_DESC, 'sort' => SORT_ASC])->all();

        foreach($persons as $row){
            $urls[] = array(
                Yii::$app->urlManager->createUrl(['/person/' . $row['url_alias']])
            , 'weekly'
            );
        }

        return $urls;
    }

    public static function getProducts(){
        $urls = [];

        $products = Products::find()->where(['active' => 1])->asArray()->indexBy('id')->orderBy(['sort' => SORT_ASC])->all();

        foreach($products as $row){
            $urls[] = array(
                Yii::$app->urlManager->createUrl(['/product/' . $row['url_alias']])
            , 'weekly'
            );
        }

        return $urls;
    }

    public static function getMarkets(){
        $urls = [];

        $cities = Cities::find()->where(['active' => 1])->orderBy(['sort' => SORT_ASC])->indexBy('id')->asArray()->all();

        foreach($cities as $row){
            $urls[] = array(
                Yii::$app->urlManager->createUrl(['/markets/' . $row['id']])
            , 'weekly'
            );
        }

        return $urls;
    }
}