<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\MarketsCities */

$this->title = $model->city;
$this->params['breadcrumbs'][] = ['label' => 'Города Где купить', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markets-cities-view">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

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
            'city:ntext',
            'is_region',
            'url_alias:url',
            'sort',
            'active',
        ],
    ]) ?>

</div>
