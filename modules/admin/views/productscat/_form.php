<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Modules\admin\models\Productscat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="productscat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?/*= $form->field($model, 'name')->textarea(['rows' => 6]) */?><!--

    <?/*= $form->field($model, 'alias')->textarea(['rows' => 6]) */?>

    <?/*= $form->field($model, 'active')->textInput() */?>

    <?/*= $form->field($model, 'sort')->textInput() */?>

    <div class="form-group">
        <?/*= Html::submitButton('Save', ['class' => 'btn btn-success']) */?>
    </div>-->

    <div class="group">

        <?= $form->field($model, 'active')->checkbox([1, 0]); ?>
        <?/*= $form->field($model, 'sort')->textInput(['maxlength' => 5, 'size' => 5]) */?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style' => 'width:100%']) ?>
        <?= $form->field($model, 'url_alias')->textInput(['maxlength' => true, 'style' => 'width:100%' ]) ?>
    </div>



    <div class="row">
        <div class="col-md-12">

        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>



    <?php ActiveForm::end(); ?>

</div>
