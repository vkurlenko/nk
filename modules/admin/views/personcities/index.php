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

$btn_sort_active = $btn_edit_active = '';

if(Yii::$app->request->get('mode')){
    $mode = Yii::$app->request->get('mode');

    if($mode == 'sort')
        $btn_sort_active = 'btn-primary active';
    else
        $btn_edit_active = 'btn-primary active';
}
else
    $btn_edit_active = 'btn-primary active';
?>
<div class="person-cities-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="flex-container" style="display: -webkit-flex;    display: flex;    justify-content: space-between;    flex-wrap: wrap;">
        <div class="btn-group" role="group" aria-label="...">
            <p>
                <?= Html::a('Создать город участника', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>

        <div class="btn-group" role="group" aria-label="...">
            <p>
                <?= Html::a('Режим редактирования', ['?mode=edit'], ['class' => 'btn btn-primary '. $btn_edit_active]) ?>
                <?= Html::a('Режим сортировки', ['?mode=sort'], ['class' => 'btn btn-primary '. $btn_sort_active]) ?>
            </p>
        </div>
    </div>

    <?php
    $columns = [
        ['class' => 'yii\grid\SerialColumn'],

        /*'id',*/
        //'name',
        [
            'attribute' => 'name',
            'value' => function($data){
                return Html::a($data->name, \yii\helpers\Url::to('/admin/personcities/update?id='.$data->id), ['target'=>'blank']);
            },
            'format' => 'raw'
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
                return \app\modules\admin\components\CheckboxWidget::widget(['data' => $data, 'attr' => 'active', 'model_name' => 'personcities']);
            },
            'format' => 'raw'
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ];
    ?>

    <?php
    if($mode == 'sort'){

        echo SortableGridView::widget([
            'dataProvider' => $dataProvider,
            'sortUrl' => Url::to(['sortItem']),
            'sortingPromptText' => 'Загрузка ...',
            'failText' => 'Ошибка сортировки',
            //'filterModel' => $searchModel,
            'columns' => $columns,
        ]);
    }
    else
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => $columns,
        ]);
    ?>


</div>
