<?php

namespace app\modules\admin\controllers;

use app\controllers\AppController;
use app\modules\admin\models\PersonCities;
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
use richardfan\sortable\SortableAction;

/**
 * PersonsController implements the CRUD actions for Persons model.
 */
class PersonsController extends AppController
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

        //AppController::log('createPerson');
        // person is active by default
        $model->active = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->person_images = UploadedFile::getInstances($model, 'person_images');
            $model->UploadImages();

            //echo $model->name; die;

            if(empty($model->url_alias))
            {
                $modelName = strtolower(\yii\helpers\StringHelper::basename(get_class($model)));
                $model->url_alias = AppController::makePrettyUrl($model->name, $modelName);
                $model->save();
            }

            // в таблицу городов участников добавим новый город, если его там нет
            if(!PersonCities::find()->where(['name' => $model->city_id])->one()){
                $city = new PersonCities();
                $city->name = $model->city_id;
                $city->sort = PersonCities::find()->max('sort') + 1;
                $city->active = 1;

                if (!$city->save()){
                    Yii::$app->session->setFlash('error', 'Страница не сохранена');
                    var_dump($city->getErrors());
                }
            }

            Yii::$app->session->setFlash('success', 'Страницы сохранена');

            return $this->redirect(['update', 'id' => $model->id]);
        }
        //}

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

            if(empty($model->url_alias))
            {
                $modelName = strtolower(\yii\helpers\StringHelper::basename(get_class($model)));
                $model->url_alias = AppController::makePrettyUrl($model->name, $modelName);
                $model->save();
            }

            // в таблицу городов участников добавим новый город, если его там нет
            if(!PersonCities::find()->where(['name' => $model->city_id])->one()){
                $city = new PersonCities();
                $city->name = $model->city_id;
                $city->sort = PersonCities::find()->max('sort') + 1;
                $city->active = 1;

                if (!$city->save()){
                    Yii::$app->session->setFlash('error', 'Страница не сохранена');
                    var_dump($city->getErrors());
                }
            }


            Yii::$app->session->setFlash('success', 'Страница сохранена');

            //return $this->redirect(['update', 'id' => $model->id]);
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


    public function actions(){
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Persons::className(),
                'orderColumn' => 'sort',
            ],
            // your other actions
        ];
    }
}
