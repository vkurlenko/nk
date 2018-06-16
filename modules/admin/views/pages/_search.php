<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\PagesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pid') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'h1') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'anons') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'images') ?>

    <?php // echo $form->field($model, 'thumbnail') ?>

    <?php // echo $form->field($model, 'kwd') ?>

    <?php // echo $form->field($model, 'dscr') ?>

    <?php // echo $form->field($model, 'tpl') ?>

    <?php // echo $form->field($model, 'params') ?>

    <?php // echo $form->field($model, 'order_by') ?>

    <?php // echo $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
