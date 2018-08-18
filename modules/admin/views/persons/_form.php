<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\components\ImageWidget;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use richardfan\sortable\SortableGridView;
use yii\helpers\Url;

mihaildev\elfinder\Assets::noConflict($this);


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Persons */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="persons-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    function arrDropDown($from = 0, $to = 1){
        $arr = [];
        for($i = $from; $i >= $to; $i-- )
            $arr[$i] = $i;
        return $arr;
    }
    ?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">

                <div class="row group">

                    <div class="col-md-6">

                    <?= $form->field($model, 'active')->checkbox([1, 0]); ?>
                    <?= $form->field($model, 'sort')->textInput(['maxlength' => 5, 'size' => 5]) ?>

                    </div>

                    <div class="col-md-6">
                    <?= $form->field($model, 'on_main')->checkbox(['0', '1']); ?>
                    <?= $form->field($model, 'on_main_sort')->dropDownList(['1' => 1, '2' => 2, '3' => 3, '4' => 4]) ?>
                    </div>

                </div>

            </div>
            <div class="col-md-6 ">
                <div class="group">
                <?= $form->field($model, 'winner')->checkbox(['0', '1']); ?>
                <?= $form->field($model, 'winner_text')->textInput(['maxlength' => true, 'style' => 'width:100%']) ?>
                </div>
            </div>
        </div>

        <div class="row group">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style' => 'width:100%' ]) ?>
                        <?= $form->field($model, 'url_alias')->textInput(['maxlength' => true, 'style' => 'width:100%' ]) ?>
                    </div>
                    <div class="col-md-3">
                        <?/*= $form->field($model, 'city_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\modules\admin\models\Cities::find()->all(), 'id', 'city')) */?>
                        <?/*=$form->field($model, 'city_id')->textInput(['maxlength' => true, 'style' => 'width:100%' ]) */?>


                        <?
                        //фомируем список

                        $listdata = \app\modules\admin\models\PersonCities::find()
                            ->select(['name'])
                            ->orderBy(['sort' => SORT_ASC])
                            //->indexBy('id')
                            ->asArray()
                            ->all();

                        $arr = [];
                        foreach($listdata as $city => $v){
                            $arr[] = $v['name'];
                        }
                        //debug($arr);
                        ?>

                        <?= $form->field($model, 'city_id')->widget(\yii\jui\AutoComplete::classname(), [
                            'clientOptions' => [
                                'source' => $arr,
                            ],
                        ]) ?>

                    </div>

                    <div class="col-md-3">
                        <?= $form->field($model, 'year')->dropDownList(arrDropDown(date('Y'), 2017 )); ?>
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'text')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder',[])]); ?>
            </div>
        </div>

        <?php
        //if($model->id):
        ?>

        <div class="row group">
            <div class="col-md-12">
                <?= $form->field($model, 'person_images[]')->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>
                <div style="clear:both;"></div>
                <?= ImageWidget::widget(['model' => $model, 'mode' => 'person']) ?>
            </div>
        </div>

        <div class="row group">
            <div class="col-md-12">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'style' => 'width:100%']) ?>
                <?= $form->field($model, 'kwd')->textInput(['maxlength' => true, 'style' => 'width:100%']) ?>
                <?= $form->field($model, 'dscr')->textInput(['maxlength' => true, 'style' => 'width:100%']) ?>

            </div>
        </div>

        <?php
       // endif;
        ?>

    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
