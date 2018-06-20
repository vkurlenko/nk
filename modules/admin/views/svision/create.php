<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Svision */

$this->title = 'Создать запись';
$this->params['breadcrumbs'][] = ['label' => 'Авторский надзор', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="svision-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
