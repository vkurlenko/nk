<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\PagesController;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

   <!-- --><?/*= $form->field($model, 'pid')->textInput() */?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="row group">
                    <?= $form->field($model, 'active')->checkbox([1, 0], ['class' => 'check']); ?>
                    <?= $form->field($model, 'pid')->dropDownList(\app\modules\admin\controllers\MenuController::getMenuSelect($model->id),  ['prompt' => 'Выберите родительский пункт']); ?>
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'style' => 'width:100%']) ?>
                    <?php
                    $arr = PagesController::getPagesSelect($model->id);

                    foreach($arr as $k => $v){
                        if($k == 0)
                            unset($arr[$k]);
                        else
                            $arr[$k] = $v;
                    }
                    $arr = ['new_url' => 'произвольный Url'] + $arr;
                    echo $form->field($model, 'url')->dropDownList($arr);
                    ?>
                    <input type="text" id="menu-url" data-tooltip="Для стороннего ресурса необходио указывать http://" class="form-control new-url" name="Menu[url]" value="<?=intval($model->url) ? '' : $model->url?>" maxlength="255" disabled style="width:100%" aria-required="true">

                </div>
            </div>
            <div class="col-md-6">
                <div class="row group">

                    <?= $form->field($model, 'class')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'sort')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>





    <?/*= $form->field($model, 'url')->textInput(['maxlength' => true]) */?>





    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
