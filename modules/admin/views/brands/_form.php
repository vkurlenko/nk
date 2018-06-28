<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\components\ImageWidget;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

mihaildev\elfinder\Assets::noConflict($this);

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Brands */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brands-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'active')->checkbox([1, 0]); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'city')->dropDownList(\yii\helpers\ArrayHelper::map(\app\modules\admin\models\Cities::find()->all(), 'id', 'city')) ?>

    <?= $form->field($model, 'url')->textInput() ?>

    <?/*= $form->field($model, 'sort')->textInput() */?>


    <?/*= $form->field($model, 'text')->textarea(['rows' => 6]) */?>
    <?= $form->field($model, 'text')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder',[])]); ?>

    <?= ImageWidget::widget(['model' => $model, 'mode' => 'image']) ?>
    <div style="clear:both;"></div>
    <?= $form->field($model, 'image')->fileInput(); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
