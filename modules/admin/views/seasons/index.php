<?php

use yii\helpers\Html;
use yii\grid\GridView;
use richardfan\sortable\SortableGridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\SeasonsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сезоны';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seasons-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новый сезон', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    \app\modules\admin\controllers\SeasonsController::getSeasons();
    ?>

    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'sortUrl' => Url::to(['sortItem']),
        'sortingPromptText' => 'Загрузка ...',
        'failText' => 'Ошибка сортировки',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'name',
                'value' => function($data){
                    return Html::a($data->name, \yii\helpers\Url::to('/admin/seasons/update?id='.$data->id), ['target'=>'_blank']);
                },
                'format' => 'raw'
            ],
            //'descr:ntext',
            //'sort',
            [
                'attribute' => 'active',
                'value' => function($data){
                    return \app\modules\admin\components\CheckboxWidget::widget(['data' => $data, 'attr' => 'active', 'model_name' => 'seasons']);
                },
                'format' => 'raw'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?/*= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            //'descr:ntext',
            //'sort',
            'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */?>
</div>
