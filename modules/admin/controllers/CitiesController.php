<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Cities;
use app\modules\admin\models\CitiesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use richardfan\sortable\SortableAction;

/**
 * CitiesController implements the CRUD actions for Cities model.
 */
class CitiesController extends Controller
{
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

    /**/

    /**
     * Lists all Cities models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CitiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cities model.
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
     * Creates a new Cities model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cities();

        $model->active = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cities model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->image = UploadedFile::getInstance($model, 'image');

            if($model->image){
                $model->upload();
            }

            unset($model->image);

            Yii::$app->session->setFlash('success', 'Страница сохранена');

            return $this->redirect(['update', 'id' => $model->id]);
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cities model.
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
     * Finds the Cities model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cities the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cities::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /*
        получим список шаблонов для выбора
    */
    public function getCities(){
        $arg = [];

        $cities = Cities::find()->asArray()->all();

        foreach($cities as $city) {
            $arg[$city['id']] = $city['city'];
        }

        return $arg;
    }

    /* сортировка записи */
    public function actionSetsort($id = null, $sort = null)
    {
        $person = Cities::findOne($id);
        $person->sort = $sort;
        $save = $person->save();

        return $save;
    }

    /* удаление картинки */
    public function actionDeleteimg($page_id, $img_id)
    {
        $page = Cities::find()
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
    public function actionSetnameimg($page_id, $img_id, $name = null, $sort = null)
    {
        $page = Cities::find()
            ->where(['id' => $page_id])
            ->one();

        $images = $page->getImages();
        $save = false;

        foreach($images as $img){
            if($img->id == $img_id){
                $save = $img->setName($name, $sort);
            }
        }
        return $save;
    }

    public function actions(){
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Cities::className(),
                'orderColumn' => 'sort',
            ],
            // your other actions
        ];
    }
}
