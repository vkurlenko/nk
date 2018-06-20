<?php

use yii\helpers\Html;
use yii\helpers\Url;
/*use yii\grid\GridView;
use app\modules\admin\controllers\PagesController;*/
use leandrogehlen\treegrid\TreeGrid;
use app\modules\admin\components\SortWidget;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <p>
        <?= Html::a('Создать страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <!-- Tree grid -->
    <div class="tree-index">


        <?=
        TreeGrid::widget([
            'dataProvider' => $dataProvider,
            'keyColumnName' => 'id',
            'parentColumnName' => 'pid',
            'parentRootValue' => '0', //first parentId value
            'pluginOptions' => [
                    //'initialState' => 'collapsed',
            ],
            'columns' => [
                'id',
                //'pid',
                [
                    'attribute' => 'title',
                    'value' => function($data){
                        if($data->pid != 0)
                            return '-' . $data->title;
                        else
                            return $data->title;
                    }
                ],
                [
                    'attribute' => 'url',
                    'value' => function($data){
                        return Html::a($data->url, Url::to($data->url, true));

                    },
                    'format' => 'html'
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
               /* [
                    'attribute' => 'order_by',
                    'value' => function($data){

                        return SortWidget::widget(['data' => $data, 'model_name' => 'pages']);
                    },
                    'format' => 'raw'
                ],*/
                'order_by',
                ['class' => 'yii\grid\ActionColumn']
            ]
        ]);
        ?>

    </div>
    <!-- /Tree grid-->



</div>
