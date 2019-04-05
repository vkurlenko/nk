<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\MarketsCities */

$this->title = 'Новый город Где купить';
$this->params['breadcrumbs'][] = ['label' => 'Города Где купить', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markets-cities-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?php
    $model->sort = $model->find()->max('sort') + 100;
    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
