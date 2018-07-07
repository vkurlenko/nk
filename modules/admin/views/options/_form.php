<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Options */
/* @var $form yii\widgets\ActiveForm */



?>

<div class="options-form">

    <?php $form = ActiveForm::begin(); ?>



    <div class="container-fluid">


                <div class="row group">

                    <div class="col-md-6">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style' => 'width:100%']) ?>

                        <?php
                        //debug(\app\modules\admin\controllers\OptionsController::getType());
                        $types = \app\modules\admin\controllers\OptionsController::getType();
                        ?>

                        <?= $form->field($model, 'type')->dropDownList($types) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'comment')->textInput(['maxlength' => true, 'style' => 'width:100%']) ?>
                    </div>
                </div>

                <div class="row group">
                    <?php

                    if($this->context->action->id != 'create'){
                        switch($model->type){
                            case 'string' :
                                echo $form->field($model, 'value')->textInput(['maxlength' => true, 'style' => 'width:100%']);
                                break;

                            case 'texthtml' :
                                echo $form->field($model, 'value')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder',[])]);
                                break;

                            case 'checkbox' :
                                echo $form->field($model, 'value')->checkbox(['0', '1']);
                                break;

                            case 'img':
                               /* echo $form->field($model, 'value')->fileInput(['multiple' => true, 'accept' => 'image/*']);

                                if(!empty($model->value)){
                                    echo Html::img($model->value, $options = ['class' => 'postImg', 'style' => ['width' => '180px']]);
                                }*/

                                echo $form->field($model, 'file_img')->fileInput(['multiple' => true, 'accept' => 'image/*']);

                                if(!empty($model->value)){
                                    echo Html::img($model->value, $options = ['class' => 'postImg', 'style' => ['width' => '180px']]);
                                }

                                /*$form->field($model, 'cover_file')->fileInput(['multiple' => true, 'accept' => 'image/*']) */?><!--
                    --><?php /*if(!empty($model->cover)){
                        echo Html::img($model->cover, $options = ['class' => 'postImg', 'style' => ['width' => '180px']]);
                    } ?>*/


                                break;

                            default:
                                echo $form->field($model, 'value')->textarea(['rows' => 6]);
                                break;
                        }
                    }
                    ?>
                </div>


    </div>








   <!-- --><?/*= $form->field($model, 'sort')->textInput() */?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
