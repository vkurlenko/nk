<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\MarketsCities;
use app\modules\admin\models\MarketsCitiesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\controllers\AppController;

use richardfan\sortable\SortableAction;

/**
 * MarketscitiesController implements the CRUD actions for MarketsCities model.
 */
class MarketscitiesController extends AppController
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
     * Lists all MarketsCities models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarketsCitiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MarketsCities model.
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
     * Creates a new MarketsCities model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MarketsCities();

        $model->active = true;

        $model->sort = $model->find()->max('sort') + 100;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if(empty($model->url_alias))
            {
                $modelName = strtolower(\yii\helpers\StringHelper::basename(get_class($model)));
                $model->url_alias = AppController::makePrettyUrl($model->city, $modelName);
                $model->save();
            }

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MarketsCities model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if(empty($model->url_alias))
            {
                $modelName = strtolower(\yii\helpers\StringHelper::basename(get_class($model)));
                $model->url_alias = AppController::makePrettyUrl($model->city, $modelName);
                $model->save();
            }

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MarketsCities model.
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
     * Finds the MarketsCities model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MarketsCities the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MarketsCities::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /* сортировка записи */
    public function actionSetsort($id = null, $sort = null)
    {
        $person = MarketsCities::findOne($id);
        $person->sort = $sort;
        $save = $person->save();
        //$save = false;
        return $save;
    }

    public function actions(){
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => MarketsCities::className(),
                'orderColumn' => 'sort',
            ],
            // your other actions
        ];
    }
}
