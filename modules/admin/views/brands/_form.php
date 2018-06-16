<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Brands */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brands-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'logo')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'city')->textarea(['rows' => 1]) ?>

    <!--<div class="form-group field-city_id has-success">
        <label class="control-label" for="city">Город</label>
        <?php
/*        $rows = (new \yii\db\Query())
            ->select(['id', 'city'])
            ->from('cities')
            ->all();

        //debug($form);
        */?>
        <select id="city" class="form-control" name="Brands[city]">
            <?php
/*            foreach($rows as $row){
                */?><option value="<?/*= $row['id']*/?>"><?/*= $row['city']*/?></option><?php
/*            }
            */?>
        </select>
    </div>-->

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
