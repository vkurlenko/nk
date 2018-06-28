<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\components\ImageWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Svision */
/* @var $form yii\widgets\ActiveForm */



?>

<div class="svision-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid group">

        <div class="row">

            <div class="col-md-6 ">
                <div class="group">
                <?= $form->field($model, 'active')->checkbox([1, 0]); ?>
                <?= $form->field($model, 'type')->dropDownList(['svision' => 'Авторский надзор', 'video' => 'Видео с участником']) ?>
                <?= $form->field($model, 'size')->dropDownList([1 => 'Большой', 0 => 'Малый']) ?>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="group">
                <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, ['language' => 'ru', 'dateFormat' => 'yyyy-MM-dd'])?>
                <?= $form->field($model, 'person_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\modules\admin\models\Persons::find()->all(), 'id', 'name')) ?>
                </div>
            </div>
        </div>
    </div>


    <div class="group">


    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'style' => 'width:100%']) ?>

    <?= $form->field($model, 'descr')->textarea(['rows' => 6]) ?>
    </div>

    <div class="container-fluid group">
        <div class="row ">
            <div class="col-md-4">
                <div class="">
                    <?= $form->field($model, 'image')->fileInput(); ?>
                <?= ImageWidget::widget(['model' => $model, 'mode' => 'image']) ?>
                <div style="clear:both;"></div>
                    <div style="clear: both"></div>

                </div>
            </div>
            <div class="col-md-8">
                <div class="">
                <?= $form->field($model, 'video')->textarea(['rows' => 6]) ?>
                </div>
            </div>
        </div>

    </div>





    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
