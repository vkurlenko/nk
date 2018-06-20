<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\components\SortWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\PersonsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Лица проекта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persons-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать Лицо проекта', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'city_id',
                'value' => function($data){
                    return $data->city->city;
                }
            ],
            'year',
            [
                'attribute' => 'winner',
                'value' => function($data){
                    if($data->winner == '1')
                        return '<span class="success">Да</span>';
                    else
                        return '<span class="danger">Нет</span>';
                },
                'format' => 'html'
            ],

            [
                'attribute' => 'on_main',
                'value' => function($data){
                    if($data->on_main == '1')
                        return '<span class="success">Да</span>';
                    else
                        return '<span class="danger">Нет</span>';
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'sort',
                'value' => function($data){

                    return SortWidget::widget(['data' => $data, 'model_name' => 'person']);
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
        ],
    ]);
    ?>
</div>
