<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\components\SortWidget;
use \app\modules\admin\components\CheckboxWidget;
use richardfan\sortable\SortableGridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\PersonsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Лица проекта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persons-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <div class="btn-group" role="group" aria-label="...">
        <?= Html::a('Создать Лицо проекта', ['create'], ['class' => 'btn btn-success']) ?>
        <?/*= Html::a('Сохранить сортировку и обновить страницу', [''], ['class' => 'btn btn-primary mass-save']) */?>
    </div>
    </p>


    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'sortUrl' => Url::to(['sortItem']),
        'sortingPromptText' => 'Загрузка ...',
        'failText' => 'Ошибка сортировки',
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            /*'id',*/
            [
                'attribute' => 'name',
                'value' => function($data){
                    return Html::a($data->name, \yii\helpers\Url::to('/admin/persons/update?id='.$data->id));
                },
                'format' => 'html',
                'options' => ['class' => 'align-left']
            ],
            [
                'attribute' => 'photo',
                'value' => function($data){
                    //$brand = new Brands();
                    $model = \app\modules\admin\models\Persons::findOne($data->id);//$this->findModel($data->id);
                    $images = $model->getImages();
                    $image = false;

                    foreach($images as $img){
                        if($img->role == 'photo_big')
                        {
                            $image = $img;
                            //debug($image); die;
                        }
                    }

                    if($image)
                        return Html::img('/'.$image->getPath('50x')); //Html::img($image->getUrl('50x')),
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'city_id',
                'value' => function($data){
                    //debug($data);
                    return $data->city_id;
                    //return $data->city->name;
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
            /*[
                'attribute' => 'sort',
                'value' => function($data){

                    return SortWidget::widget(['data' => $data, 'model_name' => 'persons']);
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
                /*'value' => function($data){
                    return CheckboxWidget::widget(['data' => $data]);
                },*/
                'format' => 'raw'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
