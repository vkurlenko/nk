<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Svision */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Svisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="svision-view">

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
            [
                'attribute' => 'person_id',
                'value' => function($data){
                    return $data->person->name;
                }
            ],
            'date',
            'title',
            'descr:ntext',
            'video:ntext',
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
        ],
    ]) ?>

</div>
