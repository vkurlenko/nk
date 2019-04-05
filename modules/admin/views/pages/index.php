<?php

use yii\helpers\Html;
use yii\helpers\Url;
/*use yii\grid\GridView;
use app\modules\admin\controllers\PagesController;*/
use leandrogehlen\treegrid\TreeGrid;
use app\modules\admin\components\SortWidget;
use richardfan\sortable\SortableGridView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
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
<div class="pages-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->


    <div class="flex-container" style="display: -webkit-flex;    display: flex;    justify-content: space-between;    flex-wrap: wrap;">
        <div class="btn-group" role="group" aria-label="...">
            <p>
                <?= Html::a('Создать страницу', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>

        <div class="btn-group" role="group" aria-label="...">
            <p>
                <?= Html::a('Режим редактирования', ['?mode=edit'], ['class' => 'btn btn-primary '. $btn_edit_active]) ?>
                <?= Html::a('Режим сортировки', ['?mode=sort'], ['class' => 'btn btn-primary '. $btn_sort_active]) ?>
            </p>
        </div>
    </div>


    <!-- Tree grid -->
    <div class="tree-index">
        <?php
        $columns = [
            'id',
            //'pid',
            /*[
                'attribute' => 'title',
                'value' => function($data){
                    if($data->pid != 0)
                        return '-' . $data->title;
                    else
                        return $data->title;
                }
            ],*/
            [
                'attribute' => 'title',
                'value' => function($data){
                    if($data->pid != 0)
                        $space = '-&nbsp;';
                    else
                        $space = '';
                    return Html::a($space.$data->title, \yii\helpers\Url::to('/admin/pages/update?id='.$data->id));
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'url',
                'value' => function($data){
                    return Html::a($data->url, Url::to($data->url, true), ['target'=>'_blank']);

                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'active',
                'value' => function($data){
                    return \app\modules\admin\components\CheckboxWidget::widget(['data' => $data, 'attr' => 'active', 'model_name' => 'pages']);
                },
                'format' => 'raw'
            ],
            /* [
                 'attribute' => 'order_by',
                 'value' => function($data){
                     return SortWidget::widget(['data' => $data, 'model_name' => 'pages']);
                 },
                 'format' => 'raw'
             ],*/
            'order_by',
            ['class' => 'yii\grid\ActionColumn']

        ];
        ?>

        <?
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
            echo TreeGrid::widget([
                    'dataProvider' => $dataProvider,
                    'keyColumnName' => 'id',
                    'parentColumnName' => 'pid',
                    'parentRootValue' => '0', //first parentId value
                    'pluginOptions' => [
                        //'initialState' => 'collapsed',
                    ],
                    'columns' => $columns
                ]);



        ?>

    </div>
    <!-- /Tree grid-->



</div>
