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

    <div class="container-fluid">

        <?= $form->field($model, 'active')->checkbox([1, 0]); ?>
        <?= $form->field($model, 'type')->dropDownList(['svision' => 'Авторский надзор', 'video' => 'Видео с участником']) ?>

        <div class="row">
            <div class="col-md-4"><?= $form->field($model, 'person_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\modules\admin\models\Persons::find()->all(), 'id', 'name')) ?>
            </div>
            <div class="col-md-4"><?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, ['language' => 'ru', 'dateFormat' => 'yyyy-MM-dd'])?></div>
            <div class="col-md-4"><?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?></div>
        </div>
    </div>

    <?= $form->field($model, 'descr')->textarea(['rows' => 6]) ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <?= ImageWidget::widget(['model' => $model, 'mode' => 'image']) ?>
                <div style="clear:both;"></div>
                <?= $form->field($model, 'image')->fileInput(); ?>
            </div>
            <div class="col-md-8">
                <?= $form->field($model, 'video')->textarea(['rows' => 6]) ?>
                <?= $form->field($model, 'size')->dropDownList([1 => 'Большой', 0 => 'Малый']) ?>
            </div>
        </div>

    </div>





    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
