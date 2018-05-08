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
    public $orderId;
    public $ProgramPrice;
    public $PaymentMethod;
    public $creditcardHoldersName;
    public $creditcardNumber;
    public $creditcardExpireMonth;
    public $creditcardExpireYear;
    public $creditcardCVV;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $requriedItems = [
            'orderId',
            'ProgramPrice',
            'PaymentMethod',
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
            'orderId' => 'Order ID',
            'PaymentMethod' => "Please Select the Payment Method: ",
            'creditcardHoldersName' => 'Credit Card Holder\'s Name',
            'creditcardNumber' => 'Credit Card Number',
            'creditcardExpireMonth' => 'Month',
            'creditcardExpireYear' => 'Year', 
            'creditcardCVV' => 'CVV',
            'verifyCode' => 'Verification Code',
        ];
    }

}
