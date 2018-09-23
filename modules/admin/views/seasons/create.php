<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Seasons */

$this->title = 'Новый сезон';
$this->params['breadcrumbs'][] = ['label' => 'Сезоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seasons-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
