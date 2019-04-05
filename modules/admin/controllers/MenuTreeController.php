<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\MenuTree;
use app\modules\admin\models\MenuTreeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuTreeController implements the CRUD actions for MenuTree model.
 */
class MenuTreeController extends Controller
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
     * Lists all MenuTree models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuTreeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	/*
	*	построение дерева
	*/
	public function actionTree($id = 1)
	{
		return $this->render('tree', [
			'data' => MenuTree::findOne($id)->tree()
		]);
	}
	
	/*
	*	перемещение объекта
	*/
	public function actionMove($item, $action, $second)
	{
		$item_model = MenuTree::findOne($item);
		$second_model = MenuTree::findOne($second);
		
		switch($action){
			case 'after':
				$item_model->insertAfter($second_model);
				break;
				
			case 'before':
				$item_model->insertBefore($second_model);
				break;
				
			case 'over':
				$item_model->appendTo($second_model);
				break;
		}
		
		$item_model->save();
		return true;
	}
	
	public function actionViewAjax($id)
	{
		return $this->renderAjax('_form', [
			'model' => $this->findModel($id),
		]);
	}

    /**
     * Displays a single MenuTree model.
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
     * Creates a new MenuTree model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MenuTree();
		
		/*$countries = new MenuTree(['name' => 'Countries']);
		$countries->makeRoot();
*/
        if ($model->load(Yii::$app->request->post())) {		
		
			if($model->sub == null){
				$model->makeRoot();
			}
			else{			
				$parent = MenuTree::find()->andWhere(['id' => $model->sub])->one();
				//$parent = MenuTree::findOne($model->sub);
				//debug($parent);
				$model->prependTo($parent);			
			}
			
			if($model->save()){
					return $this->redirect(['view', 'id' => $model->id]);
			}            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MenuTree model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MenuTree model.
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
     * Finds the MenuTree model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MenuTree the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuTree::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
