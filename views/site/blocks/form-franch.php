<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\modules\admin\models\Options;
?>

<div id="form">
    <?php $form = ActiveForm::begin(['id' => 'franch-form', 'options' => [
            'class' => 'nk-form']]); ?>

    <?= $form->field($model, 'name', ['inputOptions' => [
        'placeholder' => $model->getAttributeLabel('name'),
    ]])->textInput(['autofocus' => false])->label(false) ?>


        <?= $form->field(
                $model,
                'phone',
                [
                    'inputTemplate' => '<div class="input-group">{input}<div class="input-group-addon"><span id="phone-mask" data-action="true">'.Html::img('/tpl/mask.jpg').'</span></div></div>',
                ])
                ->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+7 (999) 999-99-99'])
                ->textInput(['placeholder' => $model->getAttributeLabel('phone'), 'style' => 'border-right:0'])
                ->label(false)
        ?>


    <?= $form->field($model, 'email', ['inputOptions' => [
        'placeholder' => $model->getAttributeLabel('email'),
    ]])->label(false) ?>

    <?/*= $form->field($model, 'subject') */?>

    <?= $form->field($model, 'msg', ['inputOptions' => [
        'placeholder' => $model->getAttributeLabel('msg'),
    ]])->textarea(['rows' => 6])->label(false) ?>

    <?/*= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) */?>

   <!-- --><?/*= $form->field($model, 'reCaptcha')->widget(
        \himiklab\yii2\recaptcha\ReCaptcha::className(),
        ['siteKey' => '6LfanGEUAAAAAFIS5OyAFgrlAvnbt9nSRnTHP1sA']
    ) */?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'franch-button', 'class' => 'franch-submit']) ?>
    </div>

</div>


    <?php ActiveForm::end(); ?>
<?php
    $js = <<<JS
            $('form').on('beforeSubmit', function(){
                var data = $(this).serialize();
                
                $('#form').prepend('<div class="progress">  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">    <span class="">Идет отправка сообщения</span>  </div></div>')
                
                $.ajax({
                    url: '/site/franchform',
                    type: 'POST',
                    data: data,
                    success: function(res){
                        //console.log(res);
                        $('#form').html('<div class="alert alert-success">Спасибо за обращение к нам. Мы постараемся ответить вам как можно скорее</div>');
                    },
                    error: function(){
                        //alert('Error!');
                        $('#form').html('<div class="alert alert-danger">Ошибка отправки сообщения</div>');
                    }
                });
                return false;                
            });          
JS;
    $this->registerJs($js);
    ?>

<?php
//endif;
?>