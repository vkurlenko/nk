<?php

use yii\helpers\Html;
use app\modules\admin\controllers\PagesController;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Pages */

$this->title = 'Создать страницу';
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>
-->

    <?php
    $model->order_by = PagesController::getNextSort();
    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
