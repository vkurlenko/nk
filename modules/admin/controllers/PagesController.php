<?php

namespace app\modules\admin\controllers;

use app\controllers\AppController;
use Yii;
use app\modules\admin\models\Pages;
use app\modules\admin\models\Tpl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
//use rico\yii2images\models\Image;

/**
 * PagesController implements the CRUD actions for Pages model.
 */
class PagesController extends AppController
{

    public $thumbnail;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Pages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Pages::find(),
            'sort'=> [
                'defaultOrder' => [
                    'order_by' => SORT_ASC
                ]
            ]
        ]);

        /*echo $model = __CLASS__;

        die;*/

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pages model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pages();

        $model->active = 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           /* $model->image = UploadedFile::getInstance($model, 'image');

            if($model->image){
                $model->upload();
            }

            unset($model->image);*/

            $img_name = time();

            $file = UploadedFile::getInstance($model, 'file_img');

            if(!empty($file)) {
                $file->saveAs('upload/global/' . $img_name . '.' . $file->extension);
                //$model->thumbnail = '/upload/global/'.$img_name.'.'.$file->extension;;
                $model->thumbnail = serialize([
                    'src' => '/upload/global/'.$img_name.'.'.$file->extension,
                    'name'=> '',
                    'url' => '',
                    'active' => 1
                ]);
                $model->save();
            }

            $model->gallery = UploadedFile::getInstances($model, 'gallery');
            $model->UploadGallery();

            Yii::$app->session->setFlash('success', 'Страница сохранена');
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //debug($model); die;

        //$this->log('update');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $img_name = time();

            $file = UploadedFile::getInstance($model, 'file_img');

            //debug($file); //die;

            if(!empty($file)) {
                $file->saveAs('upload/global/' . $img_name . '.' . $file->extension);
                //$model->thumbnail = '/upload/global/'.$img_name.'.'.$file->extension;;

                $model->thumbnail = serialize([
                    'src' => '/upload/global/'.$img_name.'.'.$file->extension
                ]);
                $model->save();
            }

            $model->gallery = UploadedFile::getInstances($model, 'gallery');


            $model->UploadGallery();

            Yii::$app->session->setFlash('success', 'Страница сохранена');

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Finds the Pages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /*
        получим список шаблонов для выбора
    */
    public static function getTemplates(){
        $arg = [];

        $templates = Tpl::find()->asArray()->all();

        foreach($templates as $tpl) {
            $arg[$tpl['template_id']] = $tpl['name'];
        }

        return $arg;
    }

    /* получим все страницы в виде простого массива */
    public static function getAllPages()
    {
        $cats = Pages::find()->orderBy(['order_by' => SORT_ASC])->asArray()->all();

        $arr_cat = array();

        foreach($cats as $cat){
            $arr_cat[$cat['id']] = $cat;
        }

        return $arr_cat;
    }

    /* дерево страниц в виде массива */
    public static function mapTree($dataset)
    {
        $tree = array();

        foreach ($dataset as $id=>&$node) {
            if (!$node['pid']){
                $tree[$id] = &$node;
            }else{
                $dataset[$node['pid']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }

    /* дерево страниц в виде списка SELECT  */
    public static function getPagesSelect($id = null)
    {
        $arr = [];
        $arr[0] = 'Самостоятельная страница';

        $pages = PagesController::getAllPages();

        $tree = PagesController::mapTree($pages);

        if(!empty($tree)){
           foreach($tree as $row){
               $arr[$row['id']] = $row['title'];
               if($row['childs']){
                   foreach($row['childs'] as $child){
                       $arr[$child['id']] = '-'.$child['title'];
                   }
               }
           }
        }
        return $arr;
    }



    public static function getNextSort()
    {
        $n = Pages::find()->max('order_by');
        $n++;
        return $n;
    }

}
