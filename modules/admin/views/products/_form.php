<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\admin\components\ImageWidget;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="container-fluid group">

        <div class="row">

            <div class="col-md-6 ">
                <div class="group">
                    <?= $form->field($model, 'active')->checkbox([1, 0]); ?>

                    <?= $form->field($model, 'size')->dropDownList([1 => 'Большой', 0 => 'Малый']) ?>
                </div>
            </div>
        </div>
    </div>


    <div class="group">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style' => 'width:100%']) ?>

        <?= $form->field($model, 'descr')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder',[])]); ?>
    </div>

    <div class="container-fluid group">
        <div class="row ">
            <div class="col-md-4">
                <div class="">
                    <?= $form->field($model, 'cover_file')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
                    <?php if(!empty($model->cover)){
                        echo Html::img($model->cover, $options = ['class' => 'postImg', 'style' => ['width' => '180px']]);
                    } ?>

                    <div style="clear:both;"></div>


                </div>
            </div>
            <div class="col-md-8">
                <div class="">
                    <?= $form->field($model, 'video')->textarea(['rows' => 6]) ?>
                </div>
            </div>
        </div>

    </div>

    <div class="group">

        <?= $form->field($model, 'product_images[]')->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>
        <div style="clear:both;"></div>
        <?= ImageWidget::widget(['model' => $model, 'mode' => 'products']) ?>

        <div style="clear:both;"></div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
