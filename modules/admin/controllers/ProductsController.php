<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Products;
use app\modules\admin\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use richardfan\sortable\SortableAction;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    public $cover;
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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
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
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();

        $model->active = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $cover_name = time();

            $file = UploadedFile::getInstance($model, 'cover_file');

            if(!empty($file)) {
                $file->saveAs('upload/cover/' . $cover_name . '.' . $file->extension);

                $model->cover = '/upload/cover/'.$cover_name.'.'.$file->extension;;
                $model->save();
            }

            $model->product_images = UploadedFile::getInstances($model, 'product_images');
            $model->UploadImages();

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //debug($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $cover_name = time();

            $file = UploadedFile::getInstance($model, 'cover_file');

            if(!empty($file)) {
                $file->saveAs('upload/cover/' . $cover_name . '.' . $file->extension);

                $model->cover = '/upload/cover/'.$cover_name.'.'.$file->extension;;
                $model->save();
            }

            $model->product_images = UploadedFile::getInstances($model, 'product_images');
            $model->UploadImages();

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Products model.
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
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actions(){
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Products::className(),
                'orderColumn' => 'sort',
            ],
            // your other actions
        ];
    }

    /* сортировка записи */
    public function actionSetsort($id = null, $sort = null)
    {
        $person = Products::findOne($id);
        $person->sort = $sort;
        $save = $person->save();
        //$save = false;
        return $save;
    }

    /* удаление картинки */
    public function actionDeleteimg($page_id, $img_id)
    {
        $page = Products::find()
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

    /* название картинки */
    public function actionSetnameimg($page_id, $img_id, $name = null, $sort = null, $role = null)
    {
        $page = Products::find()
            ->where(['id' => $page_id])
            ->one();

        $images = $page->getImages();
        $save = false;

        foreach($images as $img){
            if($img->id == $img_id){
                $save = $img->setName($name, $sort, $role);
            }
        }
        return $save;
    }
}