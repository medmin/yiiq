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
    public $email2;
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
            'email2',
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
            'email2' => "Confirm your Email please",
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

            $msgbody =  'Date Of Birth: '. $this->dob . '<br />' .
                        'Gender: '. $this->gender . '<br />' .
                        'Phone Number: '. $this->phone . '<br />' .
                        'Home Address: '. $this->homeAddress . '<br />' .
                        'Citizenship: '. $this->citizenship . '<br />' .
                        'How Do You Find Us: '. $this->howDoYouFindUs . '<br />' .
                        'How Many Weeks: '. $this->howManyWeeks . '<br />' .
                        'Program: '. $this->program . '<br />' .
                        'Message: '. $this->message;


            $programPrices = [
                'AcademicEnglish' => 100,
                'BusinessEnglish' => 200,
                'FundamentalEnglish' => 300,
                'GMAT'=>400,
                'GRE'=>500,
                'IELTS'=>600,
                'TOEFL'=>700,
            ];

            $msg = new Message();
            $msg->type = 1 ; // 1 == apply; 2 == contact
            $msg->email = $this->email;
            $msg->name = $this->firstName . '-' . $this->familyName;
            $msg->msgbody =$msgbody;
            $msg->createdAt = time();
            $session = Yii::$app->session;
            $session["ApplyMsg"] = [
                "Type" => "apply",
                "Email" => $this->email,
                "FirstName" => $this->firstName,
                "FamilyName" => $this->familyName,
                "DateOfBirth" => $this->dob,
                "Gender" => $this->gender,
                "PhoneNumber" => $this->phone,
                "HomeAddress" =>$this->homeAddress,
                "Citizenship" => $this->citizenship,
                "HowDoYouFindUs" => $this->howDoYouFindUs,
                "HowManyWeeks"=> $this->howManyWeeks,
                "Program" => $this->program,
                "Message" => $this->message,
                "Price" => $programPrices[$this->program]
            ];
            return $msg->save() ? 1 : 0;
         }
         else{
            return -1;
         }
         
     }
}
