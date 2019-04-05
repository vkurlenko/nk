<?php
namespace app\modules\admin\controllers;

use Yii;
use app\controllers\AppController;
use app\Modules\admin\models\Productscat;
use app\Modules\admin\models\ProductscatSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use richardfan\sortable\SortableAction;

/**
 * ProductscatController implements the CRUD actions for Productscat model.
 */
class ProductscatController extends AppController
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
     * Lists all Productscat models.
     * @return mixed
     */
    public function actionIndex()
    {
        //echo 'index'; die;
        $searchModel = new ProductscatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Productscat model.
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
     * Creates a new Productscat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Productscat();

        $model->active = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if(empty($model->url_alias))
            {
                $modelName = strtolower(\yii\helpers\StringHelper::basename(get_class($model)));
                $model->url_alias = AppController::makePrettyUrl($model->name, $modelName);
                $model->save();
            }

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Productscat model.
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
                $model->url_alias = AppController::makePrettyUrl($model->name, $modelName);
                $model->save();
            }

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Productscat model.
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

    /* сортировка записи */
    public function actionSetsort($id = null, $sort = null)
    {
        $pc = Productscat::findOne($id);
        $pc->sort = $sort;
        $save = $pc->save();

        return $save;
    }

    public function actions(){
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Productscat::className(),
                'orderColumn' => 'sort',
            ],
            // your other actions
        ];
    }

    /**
     * Finds the Productscat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Productscat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Productscat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
