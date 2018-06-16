<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Pages */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php
    $img = $model->getImage();
    //debug($img);
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'pid',
            'url:ntext',
            'h1:ntext',
            'title:ntext',
            ['attribute' => 'anons',
                'value' => $model->anons,
                'format' => 'html'
            ],
            ['attribute' => 'content',
                'value' => $model->content,
                'format' => 'html'
            ],
            'images:ntext',
            [
                'attribute' => 'thumbnail',
                'value' => "<img src='{$img->getUrl()}'",
                'format' => 'html'
            ],
            'kwd:ntext',
            'dscr:ntext',
            [
                    'attribute' => 'tpl',
                    'value' => $model->template->name,
            ],
            'params:ntext',
            'order_by',
            [
                'attribute' => 'active',
                'value' => function($data){
                    if($data->active == '1')
                        return 'Да';
                    else
                        return 'Нет';
                }
            ],
        ],
    ]) ?>

</div>
