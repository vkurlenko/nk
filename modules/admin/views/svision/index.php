<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\controllers\SvisionController;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\SvisionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = SvisionController::getTitle(Yii::$app->request->get('type')); //'Авторский надзор';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="svision-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать запись', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'person_id',
                'value' => function($data){
                    return $data->person->name;
                }
            ],
            'date',
            'title',
            'descr:ntext',
            //'video:ntext',
            //'size',
            //'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
