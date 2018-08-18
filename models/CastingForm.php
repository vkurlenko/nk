<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 09.07.2018
 * Time: 23:19
 */

namespace app\models;

use app\controllers\SiteController;
use Yii;
use yii\base\Model;

class CastingForm extends Model
{
    public $city;
    public $worktime;
    public $worktype;
    public $workstyle;
    public $win;
    public $video;
    public $file1;
    public $file2;
    public $file3;
    public $nikname;
    public $year;
    public $gender;
    public $email;
    public $phone;
    public $reCaptcha;
    public $path;
    public $arr_path;

    public function rules()
    {
        return [

            [['nikname', 'year', 'email', 'phone', 'gender', 'city'], 'required'],
            [['worktime', 'worktype', 'workstyle', 'win', 'video'], 'string'],
            // email has to be a valid email address
            [['email'], 'email'],
            [['file1', 'file2', 'file3'], 'file', 'extensions' => 'png, jpg'],

            [
                ['reCaptcha'],
                \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
                'secret' => '6LfanGEUAAAAAK0CHtHFopiAzIzmGoKK4H3LX3qK',
                'uncheckedMessage' => 'Подтвердите, что Вы не робот)'
            ]

        ];
    }

    public function attributeLabels()
    {
        return [
            //'verifyCode' => 'Подтвердите код',
            'reCaptcha' => '',
            'city'      => 'Город Вашего проживания',
            'worktime'  => 'Стаж работы',
            'worktype'  => 'Характер работы',
            'workstyle' => 'Навыки',
            'win'       => 'Что даст Вам победа в шоу?',
            'video'     => 'Ссылка на видео',
            'file1'     => 'Фотографии',
            'nikname'   => 'Псевдоним',
            'year'      => 'Год рождения',
            'gender'    => 'Ваш пол',
            'email'     => 'Email',
            'phone'     => 'Ваш телефон'
        ];
    }

    public function casting($email)
    {
        $body = 'Заявка на кастинг от пользователя '.$this->nikname."\n";
        $body .= 'Город проживания: '.$this->city."\n";

        $body .= 'Стаж работы: '.$this->worktime."\n";
        $body .= 'Характер работы: '.$this->worktype."\n";
        $body .= 'Навыки: '.$this->workstyle."\n";
        $body .= 'Что даст Вам победа в шоу?: '.$this->win."\n";
        $body .= 'Ссылка на видео: '.$this->video."\n";
        $body .= 'Год рождения: '.$this->year."\n";
        $body .= 'Пол: '.$this->gender."\n";
        $body .= 'Email: '.$this->email."\n";
        $body .= 'Телефон: '.$this->phone."\n";
        //$body .= 'Файл : '.$this->file1."\n";


        $users = SiteController::getEmails('casting-form-email');



        if ($this->validate()) {

            if($users){
                foreach($users as $user){
                    $mail = Yii::$app->mailer->compose()
                        ->setTo(trim($user))
                        ->setFrom(['narodny.konditer@yandex.ru' => $this->nikname])
                        ->setSubject('Заявка на кастинг от пользователя '.$this->nikname)
                        ->setTextBody($body);

                    foreach($this->arr_path as $path){
                        $mail->attach($path);
                    }
                     $mail->send();
                }

                foreach($this->arr_path as $path){
                    unlink($path);
                }
            }
            return true;
        }
        return false;
    }
}