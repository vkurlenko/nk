<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\components\ImageWidget;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

mihaildev\elfinder\Assets::noConflict($this);

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Cities */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cities-form">

    <?php $form = ActiveForm::begin(); ?>



    <div class="group">

        <?= $form->field($model, 'active')->checkbox([1, 0]); ?>
        <?/*= $form->field($model, 'sort')->textInput(['maxlength' => 5, 'size' => 5]) */?>
    </div>

    <div class="group">
        <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'style' => 'width:100%']) ?>

        <?= $form->field($model, 'text')->textInput(['maxlength' => true, 'style' => 'width:100%']) ?>
    </div>


    <?php
    if($model->id):?>
    <div class="group">


        <div style="clear:both;"></div>
        <?= $form->field($model, 'image')->fileInput(); ?>
        <?= ImageWidget::widget(['model' => $model, 'mode' => 'image']) ?>

        <div style="clear: both"></div>
    </div>
    <?php
    endif;
    ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
