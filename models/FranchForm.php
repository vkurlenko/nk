<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 30.06.2018
 * Time: 17:00
 */

namespace app\models;

use app\modules\admin\models\Options;
use app\controllers\SiteController;
use Yii;
use yii\base\Model;

class FranchForm extends Model
{
    public $name;
    public $phone;
    public $email;
    public $msg;
    public $verifyCode;
    public $reCaptcha;

    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'phone', 'email', 'msg'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            //['phone', 'phone'],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
          /* [
                ['reCaptcha'],
                \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
                'secret' => '6LfanGEUAAAAAK0CHtHFopiAzIzmGoKK4H3LX3qK',
                'uncheckedMessage' => 'Подтвердите, что Вы не робот)'
            ]*/

        ];
    }

    public function attributeLabels()
    {
        return [
            //'verifyCode' => 'Подтвердите код',
            //'reCaptcha' => '',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'msg' => 'Текст сообщения'
        ];
    }

    public function franch($email)
    {
        $body = 'Сообщение от пользователя '.$this->name."\n";
        $body .= 'Телефон: '.$this->phone."\n";
        $body .= 'Email: '.$this->email."\n\n\n";
        $body .= 'Сообщение: '.$this->msg;

        /*$option = Options::find()->where(['name' => 'franch-form-email'])->asArray()->one();
        $emails = $option['value'];
        $users = explode(',', $emails);
        $users[] = $email;*/
        $users = SiteController::getEmails('franch-form-email');


        if ($this->validate()) {

            if($users){
                foreach($users as $user){
                    Yii::$app->mailer->compose()
                        ->setTo(trim($user))
                        ->setFrom(['narodny.konditer@yandex.ru' => $this->name])
                        ->setSubject('Сообщение от пользователя '.$this->name)
                        ->setTextBody($body)
                        ->send();
                }
            }
            return true;
        }
        return false;
    }

}