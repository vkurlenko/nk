<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\components\ImageWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Jury */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jury-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="group">

        <?= $form->field($model, 'active')->checkbox([1, 0]); ?>
        <?/*= $form->field($model, 'sort')->textInput(['maxlength' => 5, 'size' => 5]) */?>
    </div>

    <div class="group">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style' => 'width:100%']) ?>
    </div>

    <div class="group">
        <?= $form->field($model, 'descr')->textarea(['rows' => 6]) ?>
    </div>


    <?php
    //if($model->id):?>
        <div class="group">
            <div style="clear:both;"></div>
            <?= $form->field($model, 'image')->fileInput(); ?>
            <?= ImageWidget::widget(['model' => $model, 'mode' => 'image']) ?>
            <div style="clear: both"></div>
        </div>
    <?php
   // endif;
    ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>



    <?php ActiveForm::end(); ?>

</div>
