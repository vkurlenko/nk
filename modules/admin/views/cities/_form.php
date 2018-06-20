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

    <?= $form->field($model, 'active')->checkbox([1, 0]); ?>

    <?= $form->field($model, 'city')->textInput() ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= ImageWidget::widget(['model' => $model, 'mode' => 'image']) ?>
    <div style="clear:both;"></div>
    <?= $form->field($model, 'image')->fileInput(); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
