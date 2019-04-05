<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\MenuTree */
/* @var $form yii\widgets\ActiveForm */

debug($model->errors);
?>

<div class="menu-tree-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'tree')->textInput() ?>

    <?= $form->field($model, 'lft')->textInput() ?>

    <?= $form->field($model, 'rgt')->textInput() ?>

    <?= $form->field($model, 'depth')->textInput() ?>
	-->
    
	<!--<?= $form->field($model, 'tree')->dropDownList([1]) ?>-->
	<?= $form->field($model, 'sub')->dropDownList(\yii\helpers\ArrayHelper::map(\app\modules\admin\models\MenuTree::find()->all(), 'id', 'name' )) ?>
	<!--<?= $form->field($model, 'name')->dropDownList(['корень']) ?>-->
	
	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textArea() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
