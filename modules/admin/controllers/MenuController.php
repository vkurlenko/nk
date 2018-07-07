<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Menu;
use app\modules\admin\models\MenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use richardfan\sortable\SortableAction;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
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
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);*/

        $dataProvider = new ActiveDataProvider([
            'query' => Menu::find(),
            'sort'=> [
                'defaultOrder' => [
                    'sort' => SORT_ASC
                ]
            ],
            'pagination' => false
        ]);

        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

            /*'sort'=> [
                'defaultOrder' => [
                    'sort' => SORT_ASC
                ]
            ]*/
        ]);
    }

    /**
     * Displays a single Menu model.
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
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();



        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Menu model.
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
     * Deletes an existing Menu model.
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
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /* получим все страницы в виде простого массива */
    public static function getAllMenu()
    {
        $cats = Menu::find()->orderBy(['sort' => SORT_ASC])->asArray()->all();

        $arr_cat = array();

        foreach($cats as $cat){
            //if($cat['active'] == )
                $arr_cat[$cat['id']] = $cat;
        }

        //debug($arr_cat); die;

        return $arr_cat;
    }

    /* дерево страниц в виде массива */
    public static function mapTree($dataset)
    {
        $tree = array();

        foreach ($dataset as $id=>&$node) {
            if (!$node['pid']){
                $tree[$id] = &$node;
            }else{
                $dataset[$node['pid']]['childs'][$id] = &$node;
            }
        }

        return $tree;
    }

    /* дерево страниц в виде списка SELECT  */
    public static function getMenuSelect($id = null)
    {
        $arr = [];
        $arr[0] = 'Отдельное меню';

        $menus = MenuController::getAllMenu();

        //debug($menus); die;

        $tree = MenuController::mapTree($menus);
        if(!empty($tree)){
            foreach($tree as $row){
                $arr[$row['id']] = $row['title'];

                if($row['childs']){
                    foreach($row['childs'] as $child){
                        $arr[$child['id']] = '-'.$child['title'];

                        if($child['childs']){
                            foreach($child['childs'] as $child2){
                                $arr[$child2['id']] = '--'.$child2['title'];
                            }
                        }
                    }
                }
            }
        }

        //debug($arr); die;
        return $arr;
    }

    public static function getMenuLevel($id = null){

        $menus = MenuController::getAllMenu();

        $tree = MenuController::mapTree($menus);

        $i = 0;
        if(!empty($tree)){
            foreach($tree as $row){
                $arr[$row['id']] = $row['title'];

                if($row['id'] == $id)
                    return $i;

                if($row['childs']){
                    foreach($row['childs'] as $child){
                        //$arr[$child['id']] = '-'.$child['title'];

                        if($child['id'] == $id)
                            return $i+1;

                        if($child['childs']){
                            foreach($child['childs'] as $child2){
                                if($child2['id'] == $id)
                                    return $i+2;

                                //$arr[$child2['id']] = '--'.$child2['title'];

                                if($child2['childs']){
                                    foreach($child2['childs'] as $child3){
                                        if($child3['id'] == $id)
                                            return $i+3;

                                        $arr[$child3['id']] = '---'.$child3['title'];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return false;
    }

    public function actions(){
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Menu::className(),
                'orderColumn' => 'sort',
            ],
            // your other actions
        ];
    }

    /* сортировка записи */
    public function actionSetsort($id = null, $sort = null)
    {
        $person = Menu::findOne($id);
        $person->sort = $sort;
        $save = $person->save();
        //$save = false;
        return $save;
    }
}
