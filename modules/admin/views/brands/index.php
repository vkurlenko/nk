<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\BrandsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Торговые сети';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brands-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новая торговая сеть', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name:ntext',
            'logo:ntext',
            //'city',
            [
                'attribute' => 'city',
                'value' => function($data){
                    return $data->cities->city;
                }
            ],
            //'text:ntext',
            //'active',
             [
                'attribute' => 'active',
                'value' => function($data){
                    if($data->active == '1')
                        return 'активен';
                    else
                        return 'не активен';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
