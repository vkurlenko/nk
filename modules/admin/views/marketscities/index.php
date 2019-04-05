<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use richardfan\sortable\SortableGridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\MarketsCitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Города Где купить';
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
<div class="markets-cities-index">

   <!-- <h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="flex-container" style="display: -webkit-flex;    display: flex;    justify-content: space-between;    flex-wrap: wrap;">
        <div class="btn-group" role="group" aria-label="...">
            <p>
                <?= Html::a('Создать город', ['create'], ['class' => 'btn btn-success']) ?>
            </p>			
        </div>

        <div class="btn-group" role="group" aria-label="...">
            <p>
                <?= Html::a('Режим редактирования', ['?mode=edit'], ['class' => 'btn btn-primary '. $btn_edit_active]) ?>
                <?= Html::a('Режим сортировки', ['?mode=sort'], ['class' => 'btn btn-primary '. $btn_sort_active]) ?>
            </p>			
        </div>
		
		
    </div>
	
	<div class="option-block">			
		<?=\app\modules\admin\components\OptionWidget::widget(['option_name' => 'marketcities-show-all'])?><br><br>
        <?=\app\modules\admin\components\OptionWidget::widget(['option_name' => 'where-title-show'])?>
	</div>

    <?php
    $columns =  [
        ['class' => 'yii\grid\SerialColumn'],

        //'id',
        [
            'attribute' => 'city',
            'value' => function($data){
                $city = $data->city;

                /*if($data->is_region)
                    $city .= '<br>Московская область';*/

                return Html::a($city, \yii\helpers\Url::to('/admin/marketscities/update?id='.$data->id));
            },
            'format' => 'html'
        ],
        //'is_region',
        //'url_alias:url',
        //'sort',
		[
            'attribute' => 'first',
            'value' => function($data){
                return \app\modules\admin\components\CheckboxWidget::widget(['data' => $data, 'attr' => 'first', 'model_name' => 'marketscities']);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'active',
            'value' => function($data){
                return \app\modules\admin\components\CheckboxWidget::widget(['data' => $data, 'attr' => 'active', 'model_name' => 'marketscities']);
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
