<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\modules\admin\models\Options;
?>


    <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php
    else:

        ?>

    <div id="form">
        <?php $form = ActiveForm::begin(['id' => 'casting-form', 'method' => 'POST',  'options' => [
            'class' => 'nk-form']]); ?>

        <?php
        $fields = [

            'worktime' => 'textarea',
            'worktype' => 'textarea',
            'workstyle' => 'textarea',
            'win' => 'textInput',
            'video'=> 'textInput',
            'file1' => 'fileInput',
            'file2' => 'fileInput',
            'file3' => 'fileInput',
            'nikname' => 'textInput',
            'year' => 'textInput',
            'gender' => 'dropDownList',
            'email' => 'textInput',
            'phone' => 'phone',
            'city' => 'textInput',
        ];
        ?>

        <?php
        foreach($fields as $field => $type):?>

            <?php
            switch($type){
                case 'textarea':
                    $param = ['rows' => 3];
                    break;

                case 'fileInput':
                    $param = ['multiple' => false, 'accept' => 'image/*'];
                    break;

                default:
                    $param = ['maxlength' => true, 'style' => 'width:100%', 'autofocus' => false];
                    break;
            };
            ?>

            <?php
            if($type == 'phone'):
            ?>
                <?= $form->field(
                $model,
                'phone',
                [
                    'inputTemplate' => '<div class="input-group">{input}<div class="input-group-addon"><span id="phone-mask" data-action="true">'.Html::img('/tpl/mask.jpg').'</span></div></div>',
                ])
                ->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '+7 (999) 999-99-99',
                ])->textInput(['placeholder' => $model->getAttributeLabel('phone'), 'style' => 'border-right:0'])
                ->label(false)
                ?>
            <?php
            elseif($type == 'dropDownList'):
                $items = [
                    'женский' => 'женский',
                    'мужской' => 'мужской'
                ];
                $param = ['prompt' => 'Ваш пол',];
                ?>

                <?= $form->field($model, $field, ['inputOptions' => [
                    'placeholder' => $model->getAttributeLabel($field),
                ]])->$type($items, $param)->label(false) ?>

                <?php
            else:
                ?>

                <?= $form->field($model, $field, ['inputOptions' => [
                    'placeholder' => $model->getAttributeLabel($field),
                ]])->$type($param)->label(false) ?>

            <?php
            endif;
            ?>

        <?php
        endforeach;
        ?>

      <?= $form->field($model, 'reCaptcha')->widget(
            \himiklab\yii2\recaptcha\ReCaptcha::className(),
            ['siteKey' => '6LfanGEUAAAAAFIS5OyAFgrlAvnbt9nSRnTHP1sA']
        )->label(false)?>

        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'franch-button', 'class' => 'franch-submit']) ?>
        </div>

    </div>


<?php ActiveForm::end(); ?>

        <?php
    endif;
        ?>
<?php/*
$js = <<<JS
            $('form').on('beforeSubmit', function(){
                var data = $(this).serialize();
                
                $('#form').prepend('<div class="progress">  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">    <span class="">Идет отправка сообщения</span>  </div></div>')
                
                $.ajax({
                    url: '/casting',
                    type: 'POST',
                    data: data,
                    success: function(res){
                        //console.log(res);
                        $('#form').html('<div class="alert alert-success">Спасибо за обращение к нам. Мы постараемся ответить вам как можно скорее</div>');
                    },
                    error: function(res){
                        //console.log(res);         
                       
                        alert('Error!');
                        $('#form').html('<div class="alert alert-danger">Ошибка отправки сообщения</div>');
                    }
                });
                return false;                
            });          
JS;
$this->registerJs($js);*/
?>

<?php
//endif;
?>