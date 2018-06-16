<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Markets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="markets-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'city')->textInput() ?>

    <?= $form->field($model, 'brands')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'anons')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'text')->textInput() ?>

    <?= $form->field($model, 'active')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
