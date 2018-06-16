<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Tpl */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tpl-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'template_id')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
