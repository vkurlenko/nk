<?php

use yii\helpers\Html;

use richardfan\sortable\SortableGridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\OptionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="options-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать опцию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'sortUrl' => Url::to(['sortItem']),
        'sortingPromptText' => 'Загрузка ...',
        'failText' => 'Ошибка сортировки',
        //'filterModel' => $searchModel,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'type',
            [
                'attribute' => 'name',
                'value' => function($data){
                    return '<div class="data-align-left">'.Html::a($data->name, \yii\helpers\Url::to('/admin/options/update?id='.$data->id)).'</div>';
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'value',
                'value' => function($data){

                switch($data->type){
                    case 'texthtml' :
                        return '<div class="data-align-left"><em>{HTML}</em></div>';
                        break;

                    case 'img':
                        return '<div class="data-align-left">'.Html::img($data->value, ['width' => 50]).'</div>';
                        break;


                    default :
                        return '<div class="data-align-left">'.$data->value.'</div>';
                        break;
                }

                    /*if($data->type != 'texthtml')
                        return '<div class="data-align-left">'.$data->value.'</div>';
                    else
                        return '<div class="data-align-left"><em>{HTML}</em></div>';*/
                },
                'format' => 'raw',
                //'filterRowOptions' => ['class' => 'filters']

            ],
            [
                'attribute' => 'comment',
                'value' => function($data){

                        return '<div class="data-align-left">'.$data->comment.'</div>';
                },
                'format' => 'raw',
                //'filterRowOptions' => ['class' => 'filters']

            ],
            //'sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
