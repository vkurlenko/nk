<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\Modules\admin\models\Productscat */

$this->title = 'Новая категория';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productscat-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
