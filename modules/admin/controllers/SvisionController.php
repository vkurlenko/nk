<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Persons;
use Yii;
use app\modules\admin\models\Svision;
use app\modules\admin\models\SvisionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\controllers\AppController;
use yii\helpers\Json;

/**
 * SvisionController implements the CRUD actions for Svision model.
 */
class SvisionController extends AppController
{
    /*public $type_title = [
        'svision' => 'Авторский надзор',
        'video'   => 'Видео с участником'
    ];*/

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
     * Lists all Svision models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SvisionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Svision model.
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
     * Creates a new Svision model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Svision();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Svision model.
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
     * Deletes an existing Svision model.
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
     * Finds the Svision model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Svision the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Svision::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public static function getTitle($type = null){
        $type_title = [
            'svision' => 'Авторский надзор',
            'video'   => 'Видео с участником'
        ];
        return $type_title[$type];
    }

    public static function getYear(){
        $year = Persons::find()->select(['year'])->orderBy(['year' => SORT_DESC])->asArray()->distinct()->all();

        $arr = [];
        foreach($year as $y){
            $arr[$y['year']] = $y['year'];

        }

        return $arr;
    }

    public static function getCity($year){
        $city = Persons::find()->select(['city_id', 'id'])->where(['year' => $year] )->orderBy(['city_id' => SORT_ASC])->asArray()->all();

        $arr = [];
        foreach($city as $c){
            $arr[$c['city_id']] = ['id' => $c['city_id'], 'name' => $c['city_id']];
            //$arr[$c['city_id']] = $c['city_id'];
        }

        return $arr;
    }

    public static function getCity2($year){
        $city = Persons::find()->select(['city_id', 'id'])->where(['year' => $year] )->orderBy(['city_id' => SORT_ASC])->asArray()->all();

        $arr = [];
        foreach($city as $c){
            $arr[$c['city_id']] = $c['city_id'];
        }

        return $arr;
    }

    public static function getPerson($year, $city){
        $arr = Persons::find()->select(['name', 'id'])->where(['year' => $year, 'city_id' => $city])->orderBy(['id' => SORT_ASC])->asArray()->all();

        return ['out' => $arr, 'selected' => []];
    }

    public static function getPerson2($year, $city){
        $arr = Persons::find()->select(['name', 'id'])->where(['year' => $year, 'city_id' => $city])->orderBy(['id' => SORT_ASC])->asArray()->all();

        $n = [];
        foreach($arr as $a){
            $n[$a['id']] = $a['name'];

        }

        return $n;
    }

    public static function getPersonData($id){
        $data = Persons::find()->where(['id' => $id])-> asArray()->one();

        return $data;
    }

    public function actionGetCity(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $year = $parents[0];
                $out = self::getCity($year);
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                return json_encode(['output'=>$out, 'selected'=>'']);
                //return;
            }
        }
        return json_encode(['output'=>'', 'selected'=>'']);
    }

    public function actionGetPerson(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $year = empty($ids[0]) ? null : $ids[0];
            $city = empty($ids[1]) ? null : $ids[1];
            if ($year != null) {
                $data = self::getPerson($year, $city);
                /**
                 * the getProdList function will query the database based on the
                 * cat_id and sub_cat_id and return an array like below:
                 *  [
                 *      'out'=>[
                 *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
                 *          ['id'=>'<prod_id_2>', 'name'=>'<prod-name2>']
                 *       ],
                 *       'selected'=>'<prod-id-1>'
                 *  ]
                 */

                return json_encode(['output'=>$data['out'], 'selected'=>$data['selected']]);
                //return;
            }
        }
        return json_encode(['output'=>'', 'selected'=>'']);
    }
}
