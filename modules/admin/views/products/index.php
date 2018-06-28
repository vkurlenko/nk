<?php

use yii\helpers\Html;
use yii\grid\GridView;
use richardfan\sortable\SortableGridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Продукция';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

   <!-- <h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать продукт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'sortUrl' => Url::to(['sortItem']),
        'sortingPromptText' => 'Загрузка ...',
        'failText' => 'Ошибка сортировки',
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'name',
                'value' => function($data){
                    return Html::a($data->name, \yii\helpers\Url::to('/admin/products/update?id='.$data->id));
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'photo',
                'value' => function($data){
                    //$brand = new Brands();
                    $model = \app\modules\admin\models\Products::findOne($data->id);//$this->findModel($data->id);
                    $images = $model->getImages();

                    $arr = [];

                    foreach($images as $img)
                        $arr[$img->sort] = $img;

                    ksort($arr);
                    $f = array_shift($arr);

                    if($f)
                        return Html::img('/'.$f->getPath('50x')); //Html::img($image->getUrl('50x')),
                },
                'format' => 'raw'
            ],
            //'descr:ntext',
            //'sort',
            [
                'attribute' => 'size',
                'value' => function($data){
                    if($data->size == '1')
                        return 'Большой';
                    else
                        return 'Малый';
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
            //'size',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
