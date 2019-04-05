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

//$mode = 'edit';
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

$cities = \app\modules\admin\controllers\DefaultController::getPersonCities();

$arrCities = [];
foreach($cities as $k => $v){
    $arrCities[$v['id']] = $v['name'];
}

$q = '';
if(Yii::$app->request->get('year'))
    $q .= '&year='.Yii::$app->request->get('year');
if(Yii::$app->request->get('city'))
    $q .= '&city='.Yii::$app->request->get('city');

?>
<div class="persons-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>


    <div class="flex-container" style="display: -webkit-flex;    display: flex;    justify-content: space-between;    flex-wrap: wrap;">
        <div class="btn-group" role="group" aria-label="...">
            <p>
            <?= Html::a('Создать Лицо проекта', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>

        <div class="btn-group" role="group" aria-label="...">
            <p>
                <select id="person-city">
                    <option value="">Все города</option>
                    <?php
                    $i = 0;
                    foreach($arrCities as $k => $v){
                        $s = '';
                        if(Yii::$app->request->get('city') && Yii::$app->request->get('city') == $v)
                            $s = 'selected';
                        echo '<option value="'.$v.'" '.$s.'>'.$v.'</option>';
                    }
                    ?>
                </select>

                <?= Html::a('Режим редактирования', ['?mode=edit'.$q], ['class' => 'btn btn-primary '. $btn_edit_active]) ?>
                <?= Html::a('Режим сортировки', ['?mode=sort'.$q], ['class' => 'btn btn-primary '. $btn_sort_active]) ?>
            </p>
        </div>
    </div>

    <?php
    $columns = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'name',
            'value' => function($data){
                return Html::a($data->name, \yii\helpers\Url::to('/admin/persons/update?id='.$data->id), ['target'=>'_blank']);
            },
            'format' => 'raw',
            'options' => ['class' => 'align-left']
        ],
        [
            'attribute' => 'photo',
            'value' => function($data){
                $model = \app\modules\admin\models\Persons::findOne($data->id);//$this->findModel($data->id);
                $images = $model->getImages();
                $image = false;

                foreach($images as $img){
                    if($img->role == 'photo_big')
                        $image = $img;
                }

                if($image)
                    return Html::img('/'.$image->getPath('50x')); //Html::img($image->getUrl('50x')),
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'city_id',
            'value' => function($data){
                return $data->city_id;
            }
        ],
        [
            'attribute' => 'year',
            'value' => function($data){
                $seasons = \app\modules\admin\controllers\SeasonsController::getSeasons();
                if($seasons){
                    foreach($seasons as $s => $v){
                        if($data->year == $v['id'])
                            return $v['name'];
                    }
                }
            }
        ],
        //'year',
        /*[
            'attribute' => 'winner',
            'value' => function($data){
                if($data->winner == '1')
                    return '<span class="success">Да</span>';
                else
                    return '<span class="danger">Нет</span>';
            },
            'format' => 'html'
        ],*/
        [
            'attribute' => 'winner',
            'value' => function($data){
                return \app\modules\admin\components\CheckboxWidget::widget(['data' => $data, 'attr' => 'winner', 'model_name' => 'persons']);
            },
            'format' => 'raw'
        ],

        /*[
            'attribute' => 'on_main',
            'value' => function($data){
                if($data->on_main == '1')
                    return '<span class="success">Да</span>';
                else
                    return '<span class="danger">Нет</span>';
            },
            'format' => 'html'
        ],*/
        [
            'attribute' => 'on_main',
            'value' => function($data){
                return \app\modules\admin\components\CheckboxWidget::widget(['data' => $data, 'attr' => 'on_main', 'model_name' => 'persons']);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'active',
            'value' => function($data){
                return \app\modules\admin\components\CheckboxWidget::widget(['data' => $data, 'attr' => 'active', 'model_name' => 'persons']);
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
