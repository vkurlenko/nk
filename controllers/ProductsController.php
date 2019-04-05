<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 27.06.2018
 * Time: 22:42
 */

namespace app\controllers;

use app\modules\admin\models\Products;
use app\modules\admin\models\Productscat;
use Yii;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;


class ProductsController extends AppController
{

    public $gallery;

    public function actionIndex(){

        $page_data = SiteController::getPageDataByUrl();
        $cat = [];

        // если указана категория продукции
        if(Yii::$app->request->get('cat')){
            $cat = self::getProductcat(Yii::$app->request->get('cat'));

            if($cat){
                $products = Products::find()->where(['active' => 1, 'cid' => $cat['id']])->asArray()->indexBy('id')->orderBy(['sort' => SORT_ASC])->all();
            }
            else
                $products = Products::find()->where(['active' => 1])->asArray()->indexBy('id')->orderBy(['sort' => SORT_ASC])->all();
        }
        else
            $products = Products::find()->where(['active' => 1])->asArray()->indexBy('id')->orderBy(['sort' => SORT_ASC])->all();

        foreach($products as $product){
            $products[$product['id']]['gallery'] = $this->getGallery($product['id']);
        }
        return $this->render('index', compact('products', 'page_data', 'cat'));
    }

    public function actionProduct(){

        if(Yii::$app->request->get('id')){
            $id = Yii::$app->request->get('id');
        }

        if($id){
            $product = Products::find()->where(['url_alias' => $id])->asArray()->one();
            $product['gallery'] = $this->getGallery($product['id']);

            if($product['video']){
               /* $sl = strrpos($product['video'], '/');
                $product['video'] = substr($product['video'], $sl+1);*/

                $arr = explode('/', $product['video']);
                foreach($arr as $el){
                    if($el != ''){

                        if(stripos($el, 'rutube') !== false)
                            $product['source'] = 'rutube';
                        elseif(stripos($el, 'you') !== false)
                            $product['source'] = 'youtube';

                        $product['video'] = $el;
                    }
                }
            }

            if($product['cover']){
                $arr = unserialize($product['cover']);

                $product['cover'] = $arr['src'];
            }
        }

        return $this->render('product', compact('product'));
    }

    public function getGallery($id = null){

        $gallery = [];

        if($id){
            $model = Products::findOne($id);
            $images = $model->getImages();

            /*foreach($images as $img){
                if($img->active){
                    $gallery[$img->sort] = [
                        'img' => $img->getPath('460x330'),
                        'sort' => $img->sort,
                        'active' => $img->active
                    ];
                }
            }*/
            foreach($images as $img){
                if($img->active){
                    $gallery[] = [
                        'img' => $img->getPath('460x330'),
                        'sort' => $img->sort,
                        'active' => $img->active
                    ];
                }
            }

            ksort($gallery);
        }
        return $gallery;
    }

    /**
     * прочитаем категорию продукции по url_alias
     */
    public function getProductcat($url_alias = null)
    {
        if($url_alias){
            $pcat = Productscat::find()->where(['url_alias' => $url_alias])->asArray()->one();

            if($pcat)
                return $pcat;
        }
        return false;

    }
}