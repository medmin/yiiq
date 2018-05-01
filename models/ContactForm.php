<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Message;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $message;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and message are required
            [['name', 'email', 'subject', 'message'], 'required'],
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

    public function contact()
    {
        $msg = new Message();

        $msgbody = $this->subject . '<br />' . $this->message;

        $msg->type = 2 ; // 1 == apply; 2 == contact, 3 == pay
        $msg->email = $this->email;
        $msg->name = $this->name;
        $msg->msgbody =$msgbody;
        $msg->createdAt = time();
        return $msg->save() ? 1 : 0;
    }
    
}
