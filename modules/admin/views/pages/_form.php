<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\PagesController;
use mihaildev\ckeditor\CKEditor;
use yii\web\UploadedFile;
use \yii\helpers\Url;
use app\modules\admin\components\ImageWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pid')->dropDownList(PagesController::getPagesSelect($model->id),  ['prompt' => 'Выберите родительский раздел']); ?>

    <?= $form->field($model, 'url')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'h1')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'anons')->widget(CKEditor::className(), ['options' => ['rows' => 3]]); ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), ['options' => ['rows' => 6]]);?>


    <?= ImageWidget::widget(['model' => $model, 'mode' => 'image']) ?>
    <div style="clear:both;"></div>
    <?= $form->field($model, 'image')->fileInput(); ?>

    <?= ImageWidget::widget(['model' => $model, 'mode' => 'gallery']) ?>
    <div style="clear:both;"></div>
    <?= $form->field($model, 'gallery[]')->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>

    <?= $form->field($model, 'kwd')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'dscr')->textarea(['rows' => 3]) ?>

    <?  /*echo$form->field($model, 'tpl')->textInput()*/ ?>

    <?php
        echo $form->field($model, 'tpl')->dropDownList(PagesController::getTemplates(), ['prompt' => 'Выберите шаблон']);
    ?>

    <?= $form->field($model, 'params')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'order_by')->textInput() ?>

    <?= $form->field($model, 'active')->checkbox(['0', '1']); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
