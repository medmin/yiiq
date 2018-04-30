<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ApplyForm is the model behind the apply form.
 */
class ApplyForm extends Model
{
    public $firstName;
    public $familyName;
    public $country;
    public $email;
    public $program;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // fistname, familyname, email, program and body are required
            [['fistName', 'familyName', 'country', 'email', 'program', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
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
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->firstName . " " . $this->familyName])
                ->setSubject($this->program)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}
