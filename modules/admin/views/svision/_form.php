<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\components\ImageWidget;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use app\modules\admin\controllers\SvisionController;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Svision */
/* @var $form yii\widgets\ActiveForm */

/*$m_person = \app\modules\admin\models\Persons::className();
echo $form->field($m_person, 'id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\modules\admin\models\Persons::find()->all(), 'id', 'name'));*/

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
                <?/*= $form->field($model, 'year')->dropDownList(\yii\helpers\ArrayHelper::map(\app\modules\admin\models\Persons::find()->select(['year'])->orderBy(['year' => SORT_DESC])->asArray()->distinct()->all(), 'year', 'year')) */?><!--
                -->

                <!---->
                <?/*= $form->field($model, 'year')->dropDownList(SvisionController::getYear(),
                    ['prompt' => 'Выберите год...',
                        'id' => 'year']) */?>
                <?php
                $data = SvisionController::getPersonData($model->person_id);
                //debug($data);

                //debug(SvisionController::getCity($data['year']));

                //debug(SvisionController::getPerson2($data['year'], $data['city_id']));
                ?>

                    <div class="person-param">
                        <?= Html::label('Год', 'year', ['class' => '']) ?>
                        <?= Html::dropDownList('year', [$data['year']], SvisionController::getYear(), ['prompt' => 'Выберите год...', 'id' => 'year', 'class' => 'form-control']);?>
                    </div>

                    <div class="person-param">
                <?= $form->field($model, 'city')->widget(DepDrop::className(), [
                        'data' => SvisionController::getCity2($data['year']),
                        'options'=>['id'=>'city', 'prompt' => 'Выберите город...', 'data-selected' => $data['city_id']],
                        'pluginOptions'=>[
                            'depends'=>['year'],
                            'placeholder'=>'Выберите город...',
                            'url'=>Url::to(['/admin/svision/get-city']),

                            ],

                    ]) ?>
                    </div>

                    <div class="person-param">

                <?= $form->field($model, 'person_id')->widget(DepDrop::classname(), [
                    'data' => SvisionController::getPerson2($data['year'], $data['city_id']),
                    'options' => ['prompt' => 'Выберите участника'],
                    'pluginOptions'=>[
                        'depends'=>['year', 'city'],
                        'placeholder'=>'Выберите участника...',
                        'url'=>Url::to(['/admin/svision/get-person'])
                    ]
                ]); ?>
                    </div>

                    <div style="clear: both"></div>
                <!---->

                <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, ['language' => 'ru', 'dateFormat' => 'yyyy-MM-dd'])?>
                <?/*= $form->field($model, 'person_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\modules\admin\models\Persons::find()->all(), 'id', 'name')) */?>

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

