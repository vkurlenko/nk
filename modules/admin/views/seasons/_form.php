<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Seasons */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seasons-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descr')->textarea(['rows' => 6]) ?>

    <?/*= $form->field($model, 'sort')->textInput() */?>

    <?= $form->field($model, 'active')->checkbox([1, 0]); ?>
    <?/*= $form->field($model, 'active')->textInput() */?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
