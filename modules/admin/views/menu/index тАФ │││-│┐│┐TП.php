<?php

use yii\helpers\Html;
use yii\grid\GridView;
use leandrogehlen\treegrid\TreeGrid;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Меню';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать меню', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Режим редактирования', ['?mode=edit'], ['class' => 'btn btn-primary '. $btn_edit_active]) ?>
        <?= Html::a('Режим сортировки', ['?mode=sort'], ['class' => 'btn btn-primary '. $btn_sort_active]) ?>
    </p>

    

    <?= TreeGrid::widget([
        'dataProvider' => $dataProvider,
        'keyColumnName' => 'id',
        'parentColumnName' => 'pid',
        'parentRootValue' => Yii::$app->request->get('pid') ? Yii::$app->request->get('pid') : '0', //first parentId value
        //'filterModel' => $searchModel,
        'columns' => [
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
            'sort',
            'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php
//debug($dataProvider);
