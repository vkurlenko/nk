<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Markets */

$this->title = 'Создать точку';
$this->params['breadcrumbs'][] = ['label' => 'Где купить', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markets-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?php
    $model->sort = $model->find()->max('sort') + 100;
    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
