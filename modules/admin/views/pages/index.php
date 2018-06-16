<?php

use yii\helpers\Html;
/*use yii\grid\GridView;
use app\modules\admin\controllers\PagesController;*/
use leandrogehlen\treegrid\TreeGrid;


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
                    'attribute' => 'active',
                    'value' => function($data){
                        if($data->active == '1')
                            return 'Да';
                        else
                            return 'Нет';
                    }
                ],
                'order_by',
                ['class' => 'yii\grid\ActionColumn']
            ]
        ]);
        ?>

    </div>
    <!-- /Tree grid-->



</div>
