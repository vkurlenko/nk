<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Markets */

$this->title = 'Новое место где купить';
$this->params['breadcrumbs'][] = ['label' => 'Где купить', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markets-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
