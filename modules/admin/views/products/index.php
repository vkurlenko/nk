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
<div class="products-index">

   <!-- <h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="flex-container" style="display: -webkit-flex;    display: flex;    justify-content: space-between;    flex-wrap: wrap;">
        <div class="btn-group" role="group" aria-label="...">
            <p>
                <?= Html::a('Создать продукт', ['create'], ['class' => 'btn btn-success']) ?>
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

        //'id',
        [
            'attribute' => 'name',
            'value' => function($data){
                return Html::a($data->name, \yii\helpers\Url::to('/admin/products/update?id='.$data->id), ['target'=>'_blank']);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'cid',
            'value' => function($data){
                return $data->productscat->name;
            }
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
        'price:ntext',
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
                return \app\modules\admin\components\CheckboxWidget::widget(['data' => $data, 'attr' => 'active', 'model_name' => 'products']);
            },
            'format' => 'raw'
        ],
        //'size',

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
