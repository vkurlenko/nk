<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $phone;
    public $email;
    //public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'body', 'phone'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            //['phone', 'phone'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Подтвердите код',
            'name' => 'Ваше имя',
            'phone' => 'Телефон',
            'email' => 'Email',
            'body' => 'Сообщение'
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        $body = 'Сообщение от пользователя '.$this->name."\n";
        $body .= 'Телефон: '.$this->phone."\n";
        $body .= 'Email: '.$this->email."\n\n\n";
        $body .= 'Сообщение: '.$this->body;


        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom(['narodny.konditer@yandex.ru' => $this->name])
                ->setSubject('Сообщение от пользователя '.$this->name)
                ->setTextBody($body)
                ->send();

            return true;
        }
        return false;
    }
}
