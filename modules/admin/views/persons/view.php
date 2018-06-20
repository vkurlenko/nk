<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Persons */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Persons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$images = $model->getImages();
$html = '';

foreach($images as $img){
    $html .= '<img src="'.$img->getUrl('x200').'">';
}

//debug($img);
?>
<div class="persons-view">

   <!-- <h1><?/*= Html::encode($this->title) */?></h1>-->

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            'winner_text',
            'text:ntext',
            [
                'attribute' => 'person_images',
                'value' => $html,
                'format' => 'html'
            ],
            /*'photo_cake:ntext',
            'photo_on_main:ntext',*/
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
            'on_main_sort',
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
        ],
    ]) ?>

</div>
