<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Seasons;
use app\modules\admin\models\SeasonsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use richardfan\sortable\SortableAction;
use app\controllers\AppController;

/**
 * SeasonsController implements the CRUD actions for Seasons model.
 */
class SeasonsController extends AppController
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
     * Lists all Seasons models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeasonsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Seasons model.
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
     * Creates a new Seasons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Seasons();

        $model->active = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Seasons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Seasons model.
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
     * Finds the Seasons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Seasons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seasons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /* сортировка записи */
    public function actionSetsort($id = null, $sort = null)
    {
        $season = Seasons::findOne($id);
        $season->sort = $sort;
        $save = $season->save();

        return $save;
    }


    public function actions(){
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Seasons::className(),
                'orderColumn' => 'sort',
            ],
            // your other actions
        ];
    }


    public static function getSeasons($active = null){

        if($active)
            $seasons = Seasons::find()->where(['active' => 1])->orderBy(['sort' => SORT_DESC])->asArray()->indexBy('sort')->all();
         else
             $seasons = Seasons::find()->orderBy(['sort' => SORT_DESC])->asArray()->indexBy('sort')->all();

        //debug($seasons); die;
        return $seasons;
    }

    public static function getSeasonById($id = null){
        $season = Seasons::findOne($id);
        //debug($seasons); die;
        return $season;
    }
}
