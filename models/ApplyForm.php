<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Message;

/**
 * ApplyForm is the model behind the apply form.
 */
class ApplyForm extends Model
{
    public $firstName;
    public $familyName;
    public $dob;
    public $gender;
    public $phone;
    public $homeAddress;
    public $citizenship;
    public $howDoYouFindUs;
    public $email;
    public $program;
    public $message;
    public $howManyWeeks;
    public $legal;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $requriedItems = [
            'firstName', 
            'familyName', 
            'dob',
            'gender',
            'phone',
            'homeAddress',
            'citizenship', 
            'howDoYouFindUs',
            'howManyWeeks',
            'email', 
            'program', 
            'message',
            'legal'
        ];
        return [
            [$requriedItems, 'required'],
            ['email', 'email'],
            ['howManyWeeks', 'integer', 'min' => 1],
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
            'dob' => 'Date of Birth',
            'legal' => 'I agree with the Term of Use',
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * store apply info into mysql 
     * table is message
     */
     public function apply()
     {
         if ($this->legal == 1)
         {

            $msgbody =  'Date of Birth: '. $this->dob . '<br />' .
                        'Gender: '. $this->gender . '<br />' .
                        'Phone Number: '. $this->phone . '<br />' .
                        'Home Address: '. $this->homeAddress . '<br />' .
                        'Citizenship: '. $this->citizenship . '<br />' .
                        'How Do You Find Us: '. $this->howDoYouFindUs . '<br />' .
                        'How many weeks: '. $this->howManyWeeks . '<br />' .
                        'Program: '. $this->program . '<br />' .
                        'Message: '. $this->message;


            $msg = new Message();
            $msg->type = 1 ; // 1 == apply; 2 == contact
            $msg->email = $this->email;
            $msg->name = $this->firstName . '-' . $this->familyName;
            $msg->msgbody =$msgbody;
            $msg->createdAt = time();
            return $msg->save() ? 1 : 0;
         }
         else{
            return -1;
         }
         
     }
}
