<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Message;

/**
 * ApplyForm is the model behind the apply form.
 */
class PayForm extends Model
{
    public $method;
    public $service;
    public $finalPrice = 0;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $requriedItems = [
            'method',
            'service'
        ];
        return [
            [$requriedItems, 'required'],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'method' => "Please Select A Payment Method: ",
            'service' => "Nobody picks you up from the airport? We can help you! ",
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * store payment info into mysql 
     * table is message
     */
     public function pay()
     {
         if ($this->legal == 1)
         {

            $msgbody =  "Hello world";


            $msg = new Message();
            $msg->type = 3 ; // 1 == apply; 2 == contact, 3 == payment
            $msg->email = $this->email;
            $msg->name = $this->service;
            $msg->msgbody =$msgbody;
            $msg->createdAt = time();
            return $msg->save() ? 1 : 0;
         }
         else{
            return -1;
         }
         
     }
}
