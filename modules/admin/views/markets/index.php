<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\MarketsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Где купить';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="markets-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новое место где купить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'city',
            'brands:ntext',
            //'anons:ntext',
            //'text',
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
