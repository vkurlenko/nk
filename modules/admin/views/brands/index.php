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
//debug($model);

//debug($image);
?>
<div class="brands-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <p>
    <div class="btn-group" role="group" aria-label="...">
        <?= Html::a('Новая торговая сеть', ['create'], ['class' => 'btn btn-success']) ?>
        <?/*= Html::a('Сохранить сортировку и обновить страницу', [''], ['class' => 'btn btn-primary mass-save']) */?>
    </div>
    </p>

    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'sortUrl' => Url::to(['sortItem']),
        'sortingPromptText' => 'Загрузка ...',
        'failText' => 'Ошибка сортировки',
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'name',
                'value' => function($data){
                    return Html::a($data->name, \yii\helpers\Url::to('/admin/brands/update?id='.$data->id));
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'logo',
                'value' => function($data){
                        //$brand = new Brands();
                        $model = Brands::findOne($data->id);//$this->findModel($data->id);
                        $image = $model->getImage();

                        return Html::img($image->getUrl('50x'));},//Html::img($image->getUrl('50x')),
                'format' => 'raw'
            ],
            //'city',
            [
                'attribute' => 'city',
                'value' => function($data){
                    return $data->cities->city;
                }
            ],
            //'text:ntext',
            //'active',
            /*[
                'attribute' => 'sort',
                'value' => function($data){
                    return SortWidget::widget(['data' => $data, 'model_name' => 'brands']);
                },
                'format' => 'raw'
            ],*/
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
    ]); ?>
</div>
