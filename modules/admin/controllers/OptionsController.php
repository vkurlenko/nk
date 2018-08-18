<?php

namespace app\modules\admin\controllers;

use app\controllers\AppController;
use Yii;
use app\modules\admin\models\Options;
use app\modules\admin\models\OptionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use richardfan\sortable\SortableAction;
use yii\web\UploadedFile;

/**
 * OptionsController implements the CRUD actions for Options model.
 */
class OptionsController extends AppController
{
    public $value;
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
     * Lists all Options models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OptionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Options model.
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
     * Creates a new Options model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Options();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $img_name = time();

            $file = UploadedFile::getInstance($model, 'value');

            if(!empty($file)) {
                $file->saveAs('upload/global/' . $img_name . '.' . $file->extension);

                $model->value = '/upload/global/'.$img_name.'.'.$file->extension;;
                $model->save();
                $model->value = UploadedFile::getInstances($model, 'value');
                $model->UploadImages();
            }

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Options model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //AppController::log('updateOptpion');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $img_name = time();

            $file = UploadedFile::getInstance($model, 'file_img');

            if(!empty($file)) {
                $file->saveAs('upload/global/' . $img_name . '.' . $file->extension);
                $model->value = '/upload/global/'.$img_name.'.'.$file->extension;;
                $model->save();
            }

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Options model.
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
     * Finds the Options model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Options the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Options::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actions(){
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Options::className(),
                'orderColumn' => 'sort',
            ],
            // your other actions
        ];
    }

    // получим типы опций в виде массива
    public static function getType(){
        $res = Yii::$app->db->createCommand('SHOW COLUMNS FROM `options` LIKE "type"')->queryAll();
        $row = $res[0];
        $type = $row['Type'];
        preg_match('/enum\((.*)\)$/', $type, $matches);
        $vals = explode(',', $matches[1]);
        $arr = [];

        foreach($vals as $val){
            $val = trim($val, "'");
            $arr[$val] = $val;
        }

        return $arr;
    }
}
