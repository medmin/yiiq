<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ApplyForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use kartik\date\DatePicker;
// use kartik\typeahead\Typeahead;
use unclead\multipleinput\MultipleInput;


$this->title = 'Apply Now';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("


$('#applyform-email2').on('focusout', function(){
    var r = $('#applyform-email').val() === $(this).val() ? true : false;
    if (!r)
    {
        alert('Please confirm your email!');
    }
});

$('#applyform-howdidyouhearaboutus').on('change', function(){
    if ($(this).val() === 'Agency'){
        $('#a-n-div').attr('style', 'display:true;');
    }
    else{
        $('#a-n-div').attr('style', 'display:none;');
    }
       
});

$('#applyform-legal').on('change', function(){
    $('#signupSubmitBtn').attr('disabled', !this.checked );
});

var priceUnit = {
    'AE' : {a:510,b:480,c:450, MF : 115},
    'BE' : {a:325,b:325,c:0, MF:50},
    'FE' : {a:260,b:235,c:220, MF : 115},
    'TOEFL' : {a:440,b:420,c:400, MF : 140},
    'GRE' : {a:440,b:420,c:400, MF : 70},
    'GMAT' : {a:440,b:420,c:400, MF : 80},
    'IELTS' : {a:440,b:420,c:400, MF : 140}
};

var wksCategory = function(wks){
    if (wks >=1 && wks <= 12){
        return 'a';
    }
    else if (wks >=13 && wks <= 24){
        return 'b';
    }
    else if (wks >=25){
        return 'c';
    }
};

$('td').on('change keyup focusout', function(){
    var whichprogram = $('#applyform-whichprogram').val();
    var weeks = $('#applyform-weeks').val();
    var hrs = $('#applyform-hoursforpl').val();
    var StudentVisa = $('#applyform-studentvisa').val();
    var promocode = $('#applyform-promocode').val().toUpperCase();
    var NumInPromoCode = promocode.replace(/^[a-z]+/gi,'');
    var off = NumInPromoCode === '' ? 0 : NumInPromoCode;
    // console.log(off, typeof off);
    var ProgramPrice =  priceUnit[whichprogram][wksCategory(weeks)] * weeks;
    ProgramPrice = parseInt(ProgramPrice) * (100- parseInt(off)) / 100;
    $('#programprice').text(ProgramPrice);
   
    var PLprice = hrs * 50;
    $('#PLprice').text(PLprice);

    var MaterialFee = priceUnit[whichprogram]['MF'];
    $('#applyform-materialsfee').attr('value', MaterialFee);

    var StudentInsuranceFee = StudentVisa === 'YES' ? 25 * weeks : 0;
    $('#applyform-studentinsurance').attr('value', StudentInsuranceFee);
    
    var finalprice = parseFloat(ProgramPrice) + parseInt(PLprice) + 125 + parseInt(MaterialFee) + parseInt(StudentInsuranceFee);
    $('#applyform-finalprice').attr('value', finalprice);
    
});

");
?>
<div class="site-apply">
    <!-- <h1><?= Html::encode($this->title) ?></h1> -->


    <?php if (Yii::$app->session->hasFlash('ApplyFormSubmissionDbError')): ?>
        <div class="alert alert-warning">
            Thank you for applying. But it seems there is an error happened to our database. Please try again or email to us.
        </div>
    
    <?php else: ?>

        <div class="row">
            <div class="col-lg-12">

                <?php $form = ActiveForm::begin(['id' => 'apply-form']); ?>

                    <h2 class='bg-info'>Part 1. Student Information</h2>

                    <div class="row">
                        <div class="col-md-3">
                            <?= $form->field($model, 'firstName')->textInput(['autofocus' => true]) ?>
                        </div>
                    
                        <div class="col-md-3">
                            <?= $form->field($model, 'lastName') ?>
                        </div>
                    
                        <div class="col-md-3">
                            <?= $form->field($model, 'dob')
                                ->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Example: 1995-03-29'],
                                    'pluginOptions' => [
                                        'format' => 'yyyy-mm-dd'
                                        ]
                                    ]) 
                            ?> 
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'phone') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                             <?= $form->field($model, 'email') ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'email2') ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'gender')
                                        ->dropDownList(
                                            [
                                                'Male' => 'Male',
                                                'Female' => 'Female',
                                            ],
                                            [
                                                'prompt' => 'Select a gender',
                                                'id' => 'gender'
                                            ]
                                        )
                                
                                ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'citizenship')
                                        ->label('Country listed on your passport')
                                        ->dropDownList(
                                            Yii::$app->params['countries'],
                                            [
                                                'prompt' => 'Country listed on your passport'
                                            ]
                                        )
                                
                                ?> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">    
                            <?= $form->field($model, 'HowDidYouHearAboutUs')
                                    ->dropDownList(
                                    [
                                        'Google' => 'Google',
                                        'OtherSearchEngine' => 'Search Engine in my country',
                                        'Agency' => 'Agency',
                                        'Facebook'=>'Facebook',
                                        'Instagram'=>'Instagram',
                                        'Twitter' => 'Twitter',
                                        'OtherSocialMedia'=>'Social Media in my country',
                                        'Advertisement'=>'Advertisement',
                                        'ICannotRemember' => 'Sorry, I can\'t remember.',
                                    ],
                                    [
                                    'prompt'=> 'How did you hear about us?'
                                    ]
                                )
                        ?>
                        </div>
                        <div class="col-md-6" id="a-n-div" style='display:none;'>
                            <?= $form->field($model, 'AgencyName')
                                ->label(false)
                                ->textInput(
                                    [
                                        'placeholder' => 'Would you mind telling us the agency\'s name? Thanks'
                                    ]
                                ) ?>  
                        </div>
                    </div>

                    <?= $form->field($model, 'homeAddress')
                        ->widget(MultipleInput::className(),[
                            'max' => 1,
                            // 'min' => 5,
                            'columns' => [
                                [
                                    'name'  => 'Address1',
                                    'title' => 'Address 1',
                                ],
                                [
                                    'name'  => 'Address2',
                                    'title' => 'Address 2',
                                    'defaultValue' => '-',
                                ],
                                [
                                    'name'  => 'City',
                                    'title' => 'City'
                                ],
                                [
                                    'name'  => 'PostalCode',
                                    'title' => 'Postal Code',
                                    'options' => [
                                        'type' => 'number',
                                        'class' => 'input-priority',
                                    ]
                                ],
                                [
                                    'name'  => 'Country',
                                    'title'  => 'Country',
                                    'type'  => 'dropDownList',
                                    'items' => Yii::$app->params['countries'],
                                    'options' => [
                                        'prompt'=> 'Choose A Country, please.'
                                    ]
                                ]
                            ]
                        ]);
                    ?>

                    
                    <?= $form->field($model, 'message')->textarea(['rows' => 3]) ?>
                    <hr />
                    <h2 class='bg-info'>Part 2. Accommodation</h2>
                    <?= $form->field($model, 'service')
                             ->widget(MultipleInput::className(),[
                                'max' => 1,
                                'columns' => [
                                    [
                                        'name'  => 'INeedARoom',
                                        'type'  => 'dropDownList',
                                        'title' => 'Do you need Accommodation?',
                                        'items' => [
                                            'No' => 'Not required',
                                            'Homestay' => 'Yes, I need homestay.',
                                            'StudentSharedRoom'=> 'Yes, I need Student Residence. A Shared Room, please.',
                                            'StudentSingleRoom'=> 'Yes, I need Student Residence. A Single Room, please.'
                                        ],
                                        'options' => [
                                            'prompt'=> 'Do you need Accommodation?'
                                        ]
                                    ],
                                    [
                                        'name' => 'CheckInDate',
                                        'type' => DatePicker::className(),
                                        'title' => 'Check In Date (You can type it)',
                                        'defaultValue' => date('Y-m-d'),
                                        'options' => [
                                            'options' => ['placeholder' => 'Example: 1995-03-29'],
                                            'pluginOptions' => [
                                                'format' => 'yyyy-mm-dd',
                                                'todayHighlight' => true
                                            ]
                                        ]
                                    ],
                                    [
                                        'name' => 'CheckOutDate',
                                        'type' => DatePicker::className(),
                                        'title' => 'Check Out Date (You can type it)',
                                        'defaultValue' => date('Y-m-d'),
                                        'options' => [
                                            'options' => ['placeholder' => 'Example: 1995-03-29'],
                                            'pluginOptions' => [
                                                'format' => 'yyyy-mm-dd',
                                                'todayHighlight' => true
                                            ]
                                        ]
                                    ],
                                ]
                             ]);
                     ?>
                    <hr />
                    <h2 class='bg-info'>Part 3. Programs</h2>
                    <table class="table table-bordered text-center">
                        <tr>
                            <th class="text-center" width="35%">Item</th>
                            <th class="text-center">Detail</th>
                        </tr>
                        <tr>
                            <td width="35%">Choose A Program Please</td>
                            <td><?=$form->field($model, 'WhichProgram')->label(false)->dropDownList(
                                [
                                    'AE' => 'Academic English',
                                    'BE' => 'Business English',
                                    'FE' => 'Fundamental English',
                                    'TOEFL' => 'Test Prep - TOEFL',
                                    'GRE' => 'Test Prep - GRE',
                                    'GMAT' => 'Test Prep - GMAT',
                                    'IELTS' => 'Test Prep - IELTS',
                                ],
                                [
                                    'prompt' => 'Choose a program please'
                                ]) ?></td>
                        </tr>
                        <tr>
                            <td width="35%">How many weeks?</td>
                            <td><?= $form->field($model, 'Weeks')->label(false)->input('Number') ?></td>
                        </tr>
                        <tr>
                            <td width="35%">Program Start Date<br /><a href="http://www.qschool.edu/wp-content/uploads/2018/05/2018-Academic-Calendar.pdf">Click To Download the Academic Calendar</a></td>
                            <td>
                                <?= $form->field($model, 'programStartDate')->label(false)
                                        ->widget(DatePicker::classname(), [
                                            'options' => ['placeholder' => 'Example: 1995-03-29'],
                                            'pluginOptions' => [
                                                'format' => 'yyyy-mm-dd'
                                                ]
                                            ]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="35%">Program Price</td>
                            <td id="programprice">0</td>
                        </tr>
                        <tr>
                            <td width="35%">Private Lessons Hours<br />(Type 0 if you don't need it.)</td>
                            <td><?= $form->field($model, 'HoursForPL')->label(false)->input('Number') ?></td>
                        </tr>
                        <tr>
                            <td width="35%">Private Lessons</td>
                            <td id="PLprice">0</td>
                        </tr>
                        <tr>
                            <td width="35%">Application Fee</td>
                            <td><?= $form->field($model, 'ApplicationFee')->label(false)->textInput([
                                    'value' => 125,
                                    'readOnly' => true
                                ])?>
                            </td>
                        </tr>
                        <tr>
                            <td width="35%">Textbook Fee</td>
                            <td><?= $form->field($model, 'MaterialsFee')->label(false)->textInput([
                                    'value' => 0,
                                    'readOnly' => true
                                ]) ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="35%">Promo Code<br />(Leave it blank if you don't have one.)</td>
                            <td><?= $form->field($model, 'PromoCode')->label(false)->textInput([
                                    'placeholder' => 'e.g  ZF3HW4T'
                                ])?>
                            </td>
                        </tr>
                        <tr>
                            <td width="35%">Student Visa</td>
                            <td><?= $form->field($model, 'StudentVisa')
                                ->label(false)
                                ->dropDownList(
                                    [
                                        'YES' => 'Yes',
                                        'NO' => 'NO',
                                    ],
                                    [
                                        'prompt' => 'Do you need a student visa?'
                                    ]
                                ) ?> 
                            </td>
                        </tr>
                        <tr>
                            <td  width="35%">Student Insurance<br />($25 per week)</td>
                            <td>
                                <?= $form->field($model, 'StudentInsurance')->label(false)
                                        ->textInput([
                                            'value' => 0,
                                            'readOnly' => true
                                        ])
                                ?>
                             </td>
                        </tr>
                        <tr>
                            <td width="35%">Estimated Program Costs ( US Dollars )</td>
                            <td>
                                <?= $form->field($model, 'finalPrice')->label(false)->textInput([
                                    'value' => 0,
                                    'readOnly' => true
                                ]); ?>
                            </td>
                        </tr>  
                    </table>
                    
                    

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>
                    <p>

                        <p>
                        This agreement is a legally binding document when signed by the student and accepted by the school.
                        </p>
                        <p>
                        I have received a copy of the “<a href="http://www.qschool.edu/wp-content/uploads/2018/02/Terms-and-Conditions.pdf">Terms & Conditions</a>” including the refund and cancellation policy.
                        I understand the <a href="http://www.qschool.edu/wp-content/uploads/2018/02/2018-Program-Summary.pdf">course fees, schedules and starting dates</a> and I agree to the terms and conditions.
                        I hereby affirm that I have sufficient funds to pay for all course costs, as well as the cost of food, housing and all other personal expenses during the full period of my course at Q International School.
                        In case of illness or injury, I grant permission to be examined or treated as necessary.
                        I hereby certify that all the information on this application form is true and complete.
                        I certify that I have read, understand, and agree to the terms and conditions.
                        </p>
                       
                        <?= $form->field($model, 'legal')->checkbox() ?> 
                    </p> 
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button', 'id'=> 'signupSubmitBtn', 'disabled' => true]) ?>
                    </div>

                <?php ActiveForm::end(); ?>
                
            </div>
        </div>

    <?php endif; ?>
</div>
