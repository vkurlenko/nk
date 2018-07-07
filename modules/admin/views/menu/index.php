<?php

use yii\helpers\Html;
use yii\grid\GridView;
use leandrogehlen\treegrid\TreeGrid;
use richardfan\sortable\SortableGridView;
use yii\helpers\Url;
use app\modules\admin\components\SortWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Меню';
$this->params['breadcrumbs'][] = $this->title;

/*$btn_sort_active = $btn_edit_active = '';

if(Yii::$app->request->get('mode')){
    $mode = Yii::$app->request->get('mode');

    if($mode == 'sort')
        $btn_sort_active = 'btn-primary active';
    else
        $btn_edit_active = 'btn-primary active';
}
else
    $btn_edit_active = 'btn-primary active';*/
?>
<div class="menu-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать меню', ['create'], ['class' => 'btn btn-success']) ?>

       <!-- <?/*= Html::a('Режим редактирования', ['?mode=edit'], ['class' => 'btn btn-primary '. $btn_edit_active]) */?>
        --><?/*= Html::a('Режим сортировки', ['?mode=sort'], ['class' => 'btn btn-primary '. $btn_sort_active]) */?>
    </p>

    <?php
    $colomns = [
        ['class' => 'yii\grid\SerialColumn'],

        //'id',
        //'pid',
        [
            'attribute' => 'title',
            'value' => function($data){
                $level = \app\modules\admin\controllers\MenuController::getMenuLevel($data->id);

                $space = '';

                for($i = 0; $i < $level; $i++)
                    $space .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

                if(!$level)
                    $title = '<span class="current-menu">'.$space.$data->title.'</span>';
                else
                    $title = $space.$data->title;
                return Html::a($title, \yii\helpers\Url::to('/admin/menu/update?id='.$data->id));
            },
            'format' => 'html'
        ],
        'url:url',
        //'class',
        [
            'attribute' => 'sort',
            'value' => function($data){

                return SortWidget::widget(['data' => $data, 'model_name' => 'menu']);
            },
            'format' => 'raw'
        ],
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
    ];
    ?>

    <?php
    /*if($mode == 'sort'){

        echo SortableGridView::widget([
            'dataProvider' => $dataProvider,
            'sortUrl' => Url::to(['sortItem']),
            'sortingPromptText' => 'Загрузка ...',
            'failText' => 'Ошибка сортировки',
            //'filterModel' => $searchModel,
            'columns' => $columns,
        ]);
    }
    else*/
        echo TreeGrid::widget([
            'dataProvider' => $dataProvider,
            'keyColumnName' => 'id',
            'parentColumnName' => 'pid',
            'parentRootValue' => Yii::$app->request->get('pid') ? Yii::$app->request->get('pid') : '0', //first parentId value
            //'filterModel' => $searchModel,
            'pluginOptions' => [
                'initialState' => 'collapsed',
            ],
            'columns' => $colomns,
    ]);
    ?>


</div>

<?php
//debug($dataProvider);
