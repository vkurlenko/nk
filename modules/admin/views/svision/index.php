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
            //'date',
            [
                'attribute' => 'date',
                'value' => function($data){

                    return date("d.m.Y", strtotime($data->date));;
                },
                'format' => 'html'
            ],
            //Yii::$app->formatter->asDate('2014-01-01')
            [
                'attribute' => 'title',
                'value' => function($data){
                    return Html::a($data->title, \yii\helpers\Url::to('/admin/svision/update?id='.$data->id), ['target'=>'_blank']);
                },
                'format' => 'raw'
            ],
            //'descr:ntext',
            //'video:ntext',
            [
                'attribute' => 'size',
                'value' => function($data){
                    if($data->size == '1')
                        return 'Большой';
                    else
                        return 'Малый';
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'active',
                'value' => function($data){
                    return \app\modules\admin\components\CheckboxWidget::widget(['data' => $data, 'attr' => 'active', 'model_name' => 'svision']);
                },
                'format' => 'raw'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
