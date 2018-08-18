<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\Brands;
use app\modules\admin\components\SortWidget;

use richardfan\sortable\SortableGridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\BrandsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Торговые сети';
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
<div class="brands-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <div class="flex-container" style="display: -webkit-flex;    display: flex;    justify-content: space-between;    flex-wrap: wrap;">
        <div class="btn-group" role="group" aria-label="...">
            <p>
                <?= Html::a('Новая торговая сеть', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>

        <div class="btn-group" role="group" aria-label="...">
            <p>
                <?= Html::a('Режим редактирования', ['?mode=edit'], ['class' => 'btn btn-primary '. $btn_edit_active]) ?>
                <?= Html::a('Режим сортировки', ['?mode=sort'], ['class' => 'btn btn-primary '. $btn_sort_active]) ?>
            </p>
        </div>
    </div>

    <?php
    $columns = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'name',
            'value' => function($data){
                return Html::a($data->name, \yii\helpers\Url::to('/admin/brands/update?id='.$data->id), ['target'=>'blank']);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'logo',
            'value' => function($data){
                $model = Brands::findOne($data->id);
                $image = $model->getImage();

                return Html::img($image->getUrl('50x'));},
            'format' => 'raw'
        ],
        [
            'attribute' => 'city',
            'value' => function($data){
                return $data->cities->city;
            }
        ],

        [
            'attribute' => 'active',
            'value' => function($data){
                return \app\modules\admin\components\CheckboxWidget::widget(['data' => $data, 'attr' => 'active', 'model_name' => 'brands']);
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
