<?php

use yii\helpers\Html;
use yii\grid\GridView;
use richardfan\sortable\SortableGridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\JurySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Жюри';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jury-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать члена жюри', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
                    return Html::a($data->name, \yii\helpers\Url::to('/admin/jury/update?id='.$data->id), ['target'=>'blank']);
                },
                'format' => 'raw'
            ],
            //'descr:ntext',
            //'sort',
            [
                'attribute' => 'active',
                'value' => function($data){
                    return \app\modules\admin\components\CheckboxWidget::widget(['data' => $data, 'attr' => 'active', 'model_name' => 'jury']);
                },
                'format' => 'raw'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
