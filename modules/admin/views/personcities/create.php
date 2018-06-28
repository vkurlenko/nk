<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\PersonCities */

$this->title = 'Создать Город участника проекта';
$this->params['breadcrumbs'][] = ['label' => 'Города участников проекта', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-cities-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?php
    $model->sort = $model->find()->max('sort') + 100;
    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
