<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\PersonsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="persons-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'city_id') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'winner') ?>

    <?php // echo $form->field($model, 'winner_text') ?>

    <?php // echo $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'photo_big') ?>

    <?php // echo $form->field($model, 'photo_small') ?>

    <?php // echo $form->field($model, 'photo_cake') ?>

    <?php // echo $form->field($model, 'photo_on_main') ?>

    <?php // echo $form->field($model, 'on_main') ?>

    <?php // echo $form->field($model, 'on_main_sort') ?>

    <?php // echo $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
