<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Persons;
use app\modules\admin\models\PersonsSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;
use rico\yii2images\models\Image;

/**
 * PersonsController implements the CRUD actions for Persons model.
 */
class PersonsController extends Controller
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

    /**
     * Lists all Persons models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Persons model.
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
     * Creates a new Persons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Persons();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                $model->person_images = UploadedFile::getInstances($model, 'person_images');
                $model->UploadImages();

                Yii::$app->session->setFlash('success', 'Страницы сохранена');

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Persons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->person_images = UploadedFile::getInstances($model, 'person_images');
            $model->UploadImages();

            $model->person_video = UploadedFile::getInstances($model, 'person_video');
            $model->UploadVideo();

            Yii::$app->session->setFlash('success', 'Страница сохранена');

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Persons model.
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
     * Finds the Persons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Persons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Persons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /* название картинки */
    public function actionSetsort($id = null, $sort = null)
    {
        $person = Persons::findOne($id);
        $person->sort = $sort;
        $save = $person->save();

        return $save;
    }

    /* удаление картинки */
    public function actionDeleteimg($page_id, $img_id)
    {
        $page = Persons::find()
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
        $page = Persons::find()
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
