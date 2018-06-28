<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\components\SortWidget;
use richardfan\sortable\SortableGridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\PersonCitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Города участников проекта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-cities-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <p>
    <div class="btn-group" role="group" aria-label="...">
        <?= Html::a('Создать город участника', ['create'], ['class' => 'btn btn-success']) ?>
        <?/*= Html::a('Сохранить сортировку и обновить страницу', [''], ['class' => 'btn btn-primary mass-save']) */?>
    </div>
    </p>


    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'sortUrl' => Url::to(['sortItem']),
        'sortingPromptText' => 'Загрузка ...',
        'failText' => 'Ошибка сортировки',
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            /*'id',*/
            //'name',
            [
                'attribute' => 'name',
                'value' => function($data){
                    return Html::a($data->name, \yii\helpers\Url::to('/admin/personcities/update?id='.$data->id));
                },
                'format' => 'html'
            ],
            //'sort',
            /*[
                'attribute' => 'sort',
                'value' => function($data){
                    return '<i class="fa fa-arrows" aria-hidden="true"></i>';
                    // return SortWidget::widget(['data' => $data, 'model_name' => 'cities']);
                },
                'format' => 'html'
            ],*/
            [
                'attribute' => 'active',
                'value' => function($data){
                    if($data->active == '1')
                        return '<span class="success">Да</span>';
                    else
                        return '<span class="danger">Нет</span>';
                },
                'format' => 'raw'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
