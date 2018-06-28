<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\components\SortWidget;
use richardfan\sortable\SortableGridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\CitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Города';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cities-index">

   <!-- <h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <div class="btn-group" role="group" aria-label="...">
        <?= Html::a('Создать Новый город', ['create'], ['class' => 'btn btn-success']) ?>
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

            /*[
                'attribute' => 'id',
                'value' => function($data){
                    return '<i class="fa fa-arrows" aria-hidden="true"></i>';
                },
                'format' => 'html'
            ],*/
            //'city:ntext',
            [
                'attribute' => 'city',
                'value' => function($data){
                    return Html::a($data->city, \yii\helpers\Url::to('/admin/cities/update?id='.$data->id));
                },
                'format' => 'html'
            ],
            //'logo:ntext',
            [
                'attribute' => 'active',
                'value' => function($data){
                    if($data->active == '1')
                        return '<span class="success">Да</span>';
                    else
                        return '<span class="danger">Нет</span>';
                },
                'format' => 'html'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
