<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Markets;
use app\modules\admin\models\MarketsSearch;
use app\modules\admin\models\MarketsCities;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\controllers\AppController;
use richardfan\sortable\SortableAction;

/**
 * MarketsController implements the CRUD actions for Markets model.
 */
class MarketsController extends AppController
{

    /*
     * 92ef1e5f-a416-44d2-8586-4b72c927d350
     * */
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
     * Lists all Markets models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarketsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Markets model.
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
     * Creates a new Markets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Markets();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // в таблицу городов участников добавим новый город, если его там нет
            if(!MarketsCities::find()->where(['city' => $model->city])->one()){
                $city = new MarketsCities();
                $city->city = $model->city;
                $city->sort = MarketsCities::find()->max('sort') + 1;
                $city->active = 1;

               /* $modelName = strtolower(\yii\helpers\StringHelper::basename(get_class($city)));
                $city->url_alias = AppController::makePrettyUrl($model->city, $modelName);*/

                $url = AppController::yaTranslit($model->city);
                $url_alias = MarketsCities::find()->where(['LIKE', 'url_alias', [$url]])->all();
                if($url_alias){
                    $url .= '-'. count($url_alias);
                }
                $city->url_alias = $url;

                if (!$city->save()){
                    Yii::$app->session->setFlash('error', 'Страница не сохранена');
                    var_dump($city->getErrors());
                }
            }


            return $this->redirect(['view', 'id' => $model->id]);
        }



        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Markets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // в таблицу городов участников добавим новый город, если его там нет
            if(!MarketsCities::find()->where(['city' => $model->city])->one()){
                $city = new MarketsCities();
                $city->city = $model->city;
                $city->sort = MarketsCities::find()->max('sort') + 1;
                $city->active = 1;

                $url = AppController::yaTranslit($model->city);
                $url_alias = MarketsCities::find()->where(['LIKE', 'url_alias', [$url]])->all();
                if($url_alias){
                    $url .= '-'. count($url_alias);
                }
                $city->url_alias = $url;


                if (!$city->save()){
                    Yii::$app->session->setFlash('error', 'Страница не сохранена');
                    var_dump($city->getErrors());
                }
            }

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Markets model.
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
     * Finds the Markets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Markets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Markets::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public static function getMarkets()
    {
        $res = Markets::find()->where(['active' => true])->orderBy(['sort' => SORT_ASC])->asArray()->all();

        return $res;

    }

    /* сортировка записи */
    public function actionSetsort($id = null, $sort = null)
    {
        $person = Markets::findOne($id);
        $person->sort = $sort;
        $save = $person->save();
        //$save = false;
        return $save;
    }

    public function actions(){
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Markets::className(),
                'orderColumn' => 'sort',
            ],
            // your other actions
        ];
    }
}
