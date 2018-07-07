<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 27.06.2018
 * Time: 22:42
 */

namespace app\controllers;

use app\modules\admin\models\Products;
use Yii;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;


class ProductsController extends AppController
{

    public $gallery;

    public function actionIndex(){

        $products = Products::find()->where(['active' => 1])->asArray()->indexBy('id')->orderBy(['sort' => SORT_ASC])->all();

        foreach($products as $product){
            $products[$product['id']]['gallery'] = $this->getGallery($product['id']);

        }
        return $this->render('index', compact('products'));
    }

    public function actionProduct(){

        if(Yii::$app->request->get('id')){
            $id = Yii::$app->request->get('id');
        }

        if($id){
            $product = Products::find()->where(['id' => $id])->asArray()->one();
            $product['gallery'] = $this->getGallery($id);

            if($product['video']){
                $sl = strrpos($product['video'], '/');
                $product['video'] = substr($product['video'], $sl+1);
            }

            if($product['cover']){

                /*$filePath = $_SERVER['DOCUMENT_ROOT']. '/web/upload/cover';
                $img = Image::getImagine()->open(Yii::getAlias($_SERVER['DOCUMENT_ROOT']. '/web'.$product['cover']));

                $size = $img->getSize();
                $ratio = $size->getWidth()/$size->getHeight();

                $width = 560;
                $height = 315;

                if($size->getWidth() > $width){

                }

                $box = new Box($width, $height);
                $img->crop(new Point(0, 0), new Box(560, 315))->save($filePath.'/thumb/' . 'test.jpg');*/

                /*echo $_SERVER['DOCUMENT_ROOT']. '/web'.$product['cover'];
                echo $ratio; die;*/

                /*Image::frame($_SERVER['DOCUMENT_ROOT']. '/web'.$product['cover'], 5, '666', 0)
                    ->rotate(-8)
                    ->save('upload/image.jpg', ['jpeg_quality' => 50]);*/

            }
        }

        return $this->render('product', compact('product'));
    }

    public function getGallery($id = null){

        $gallery = [];

        if($id){
            $model = Products::findOne($id);
            $images = $model->getImages();

            foreach($images as $img){
                if($img->active){
                    $gallery[$img->sort] = [
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
}