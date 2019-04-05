<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\PagesController;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\web\UploadedFile;
use \yii\helpers\Url;
use app\modules\admin\components\ImageWidget;
use app\modules\admin\components\ImageOneWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid">

        <div class="row group">
            <div class="col-md-6">
                <?= $form->field($model, 'active')->checkbox([1, 0]); ?>

                <?= $form->field($model, 'pid')->dropDownList(PagesController::getPagesSelect($model->id),  ['prompt' => 'Выберите родительский раздел']); ?>

                <?= $form->field($model, 'order_by')->textInput() ?>

                <?= $form->field($model, 'url')->textInput(['style' => 'width:100%']) ?>

                <?= $form->field($model, 'h1')->textInput(['style' => 'width:100%']) ?>

                <?= $form->field($model, 'title')->textInput(['style' => 'width:100%']) ?>

               <!-- --><?/*= $form->field($model, 'tpl')->dropDownList(PagesController::getTemplates(), ['prompt' => 'Выберите шаблон']);                */?>

            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'anons')->widget(CKEditor::className(), ['options' => ['rows' => 3], 'editorOptions' => ElFinder::ckeditorOptions('elfinder',[])]); ?>
                <?/*= $form->field($model, 'text')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder',[])]); */?>

            </div>
        </div>

        <div class="row group">
            <div class="col-md-12">
                <?= $form->field($model, 'content')->widget(CKEditor::className(), ['options' => ['rows' => 6], 'editorOptions' => ElFinder::ckeditorOptions('elfinder',[])]);?>
            </div>
        </div>

        <div class="row group">
            <div class="col-md-12">
                <?/*= $form->field($model, 'image')->fileInput(); */?><!--
                <?/*= ImageWidget::widget(['model' => $model, 'mode' => 'image']) */?>
                <div style="clear:both;"></div>-->

                <?= $form->field($model, 'file_img')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

                <?php /*if(!empty($model->thumbnail)){
                    echo Html::img($model->thumbnail, $options = ['class' => 'postImg', 'style' => ['width' => '180px']]);
                } */?>
                <?= ImageOneWidget::widget(['model' => $model, 'field' => 'thumbnail']) ?>

            </div>
        </div>
        <div class="row group">
            <div class="col-md-12">
                <?= $form->field($model, 'gallery[]')->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>

                <?= ImageWidget::widget(['model' => $model, 'mode' => 'gallery']) ?>
                <div style="clear:both;"></div>

            </div>
        </div>

        <div class="row group">
            <div class="col-md-12">
                <?= $form->field($model, 'kwd')->textInput(['style' => 'width:100%']) ?>

                <?= $form->field($model, 'dscr')->textarea(['rows' => 2]) ?>

                <?= $form->field($model, 'params')->textarea(['rows' => 6]) ?>
            </div>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-save']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
