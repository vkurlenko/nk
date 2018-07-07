<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Menu */

$this->title = 'Создать меню';
$this->params['breadcrumbs'][] = ['label' => 'Меню', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?php
    $model->sort = $model->find()->max('sort') + 100;
    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
