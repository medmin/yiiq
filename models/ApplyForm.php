<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Message;
use app\models\Order;

/**
 * ApplyForm is the model behind the apply form.
 */
class ApplyForm extends Model
{
    public $firstName;
    public $lastName;
    public $dob;
    public $gender;
    public $phone;
    public $homeAddress;
    public $citizenship;
    public $HowDidYouHearAboutUs;
    public $AgencyName;
    public $email;
    public $email2;
    public $message;
    public $WhichProgram;// ae, be, fe, test prep
    public $Weeks; 
    public $HoursForPL; // Private Lesson
    public $ApplicationFee;
    public $MaterialsFee;
    public $PromoCode;
    public $StudentVisa;
    public $finalPrice;
    public $legal;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $requriedItems = [
            'firstName', 
            'lastName', 
            'dob',
            'gender',
            'phone',
            'homeAddress',
            'citizenship', 
            'HowDidYouHearAboutUs',
            'email', 
            'email2',
            'WhichProgram', 
            'Weeks',
            'message',
            'legal',
            'ApplicationFee',
            'StudentVisa'
        ];
        return [
            [$requriedItems, 'required'],
            ['HoursForPL', 'required', 'message' =>'Please input how many hours for the private lessons you purchase. You can type 0 if you don\'t need it.'],
            // ['PromoCode', 'required', 'message' => 'Type "No" if you don\'t have one.'],
            [['email'], 'trim'],
            ['email', 'email'],
            ['email2', 'compare', 'compareAttribute' => 'email', 'message' => 'Attention! The emails are not the same.'],
            ['Weeks','integer','min' => 1],
            ['legal', 'compare', 'compareValue' => 1, 'operator' => '==', 'message' => 'You need to agree with our Terms of Use and Privacy Policy.'],
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
            'dob' => 'Date of Birth (You can type it)',
            'HowDidYouHearAboutUs'=> 'How did you hear about us?',
            'email2' => "Confirm your Email please",
            'legal' => 'I have read and agree with the Term of Use (Click the link below the button)',
            'ApplicationFee' => 'Application Fee (US dollars)',
            'StudentVisa' => 'Do you need a Student Visa?',
            'verifyCode' => 'Verification Code',
        ];
    }

    public function apply()
    {
        $WeeksCategory = function($weeks){
            if ($weeks >=1 && $weeks <=12){
                return 'a';
            }
            else if ($weeks >=13 && $weeks <=24){
                return 'b';
            }
            else if ($weeks >= 25){
                return 'c';
            }
        };
        $programPricingUnit = [
            'AE' => ['a' => 510,'b'=>480,'c'=> 450, 'MF'=>115],
            'BE' => ['a' => 325,'b'=>325,'c'=> 0, 'MF'=>50],
            'FE' => ['a' => 260,'b'=>235,'c'=> 220, 'MF'=>115],
            'TOEFL' => ['a' => 440,'b'=>420,'c'=> 400, 'MF'=>140],
            'GRE' => ['a' => 440,'b'=>420,'c'=> 400, 'MF'=>70],
            'GMAT' => ['a' => 440,'b'=>420,'c'=> 400, 'MF'=>80],
            'IELTS' => ['a' => 440,'b'=>420,'c'=> 400, 'MF'=>140],
        ];

        $PromoCodeArr = Yii::$app->params['PromoCodeArr'];
        $off = array_key_exists(strtoupper($this->PromoCode), $PromoCodeArr) ? $PromoCodeArr[strtoupper($this->PromoCode)] : 0;
        $rate = round( ((100 - $off) / 100), 2);

        $orderid = "Q". date("Ymd") . crypt($this->email, Yii::$app->params['PayHashSalt']) . substr(microtime(), 0, 5) * 1000 ;
        
        $finalPrice = $rate * (int)$programPricingUnit[$this->WhichProgram][$WeeksCategory($this->Weeks)] * $this->Weeks 
                    + (int)$this->HoursForPL * 50 
                    + (int)$this->ApplicationFee 
                    + (int)$programPricingUnit[$this->WhichProgram]['MF'];

        $detail =   'First Name: ' . $this->firstName . '<br />' .
                    'Last Name: ' . $this->lastName . '<br />' .
                    'Date of Birth: ' . $this->dob . '<br />' .
                    'Gender: ' . $this->gender . '<br />' .
                    'Phone: ' . $this->phone . '<br />' .
                    'Home Address: ' . $this->homeAddress . '<br />' .
                    'Citizenship: ' . $this->citizenship . '<br />' .
                    'How Did You Hear About Us: ' . $this->HowDidYouHearAboutUs . '<br />' .
                    'Agency Name: ' . ($this->AgencyName == '' ? 'None' : $this->AgencyName) . '<br />' .
                    'Email: ' . $this->email . '<br />' .
                    'Message: ' . $this->message . '<br />' .
                    'Which Program: ' . $this->WhichProgram . '<br />' .
                    'Weeks: ' . $this->Weeks . '<br />' .
                    'Hours For Private Lessons: ' . $this->HoursForPL . '<br />' .
                    'Application Fee: ' . $this->ApplicationFee . '<br />' .
                    'Materials Fee: ' . $programPricingUnit[$this->WhichProgram]['MF'] . '<br />' .
                    'Promo Code: ' . $this->PromoCode . '<br />' .
                    'Student Visa: ' . $this->StudentVisa . '<br />' .
                    'FinalPrice: ' . $finalPrice . ' US dollars';
        
        

        $order = new Order();
        $order->orderid = $orderid;
        $order->name = $this->firstName.'-'. $this->lastName ;
        $order->email = $this->email;
        $order->detail = $detail;
        $order->price = (int)$finalPrice; 
        $order->createdAt = substr(microtime(), 0, 5) * 1000 + substr(microtime(), 11, 10) * 1000;
        if ($order->save() )
        {

            $session = Yii::$app->session;
            $session['orderInfo'] = [
                'msg' => 'Please write down the order id: ' . $order->orderid . ', which is very important!' ,
                'id' =>  $order->orderid,
                'detail' =>  $order->detail,
                'program' => $this->WhichProgram,
                'price' => (int)$finalPrice,
            ];
            return true;
        }
        else{
            // print_r($order->errors);exit;
            Yii::$app->session->setFlash('ApplyFormSubmissionDbError');
            return false;
        }
    }

    
}
