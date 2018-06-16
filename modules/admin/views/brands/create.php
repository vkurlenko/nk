<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Brands */

$this->title = 'Новая торговая сеть';
$this->params['breadcrumbs'][] = ['label' => 'Торговые сети', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brands-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
