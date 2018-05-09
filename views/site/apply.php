<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ApplyForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;


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
    var promocode = $('#applyform-promocode').val().toUpperCase();


    var ProgramPrice =  priceUnit[whichprogram][wksCategory(weeks)] * weeks;
    $('#programprice').text(ProgramPrice);

    var PLprice = hrs * 50;
    $('#PLprice').text(PLprice);

    var MaterialFee = priceUnit[whichprogram]['MF'];
    $('#applyform-materialsfee').attr('value', MaterialFee);

    var finalprice = parseInt(ProgramPrice) + parseInt(PLprice) + 125 + parseInt(MaterialFee);
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
                                    'options' => ['placeholder' => 'Example: 1995-05-11'],
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
                                    ->widget(Typeahead::classname(), 
                                    [
                                        'dataset' => [
                                            [
                                                'local' => Yii::$app->params['countries'],
                                                'limit' => 5
                                            ]
                                        ],
                                        'pluginOptions' => ['highlight' => true],
                                        'options' => ['placeholder' => 'Please input your country'],
                                    ])
                                ?>
                        </div>
                    </div>

                    <?= $form->field($model, 'homeAddress') ?>

                    <div class="row">
                    <div class="col-md-6">    
                        <?= $form->field($model, 'HowDidYouHearAboutUs')
                                ->label(false)
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
                    <table class="table table-bordered text-center">
                        <tr>
                            <th class="text-center">Item</th>
                            <th class="text-center">Detail</th>
                        </tr>
                        <tr>
                            <td>Choose A Program Please</td>
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
                            <td>How many weeks?</td>
                            <td><?= $form->field($model, 'Weeks')->label(false)->input('Number') ?></td>
                        </tr>
                        <tr>
                            <td>Program Price</td>
                            <td id="programprice">0</td>
                        </tr>
                        <tr>
                            <td>Private Lessons Hours<br />(Type 0 if you don't need it.)</td>
                            <td><?= $form->field($model, 'HoursForPL')->label(false)->input('Number') ?></td>
                        </tr>
                        <tr>
                            <td>Private Lessons</td>
                            <td id="PLprice">0</td>
                        </tr>
                        <tr>
                            <td>Application Fee</td>
                            <td><?= $form->field($model, 'ApplicationFee')->label(false)->textInput([
                                    'value' => 125,
                                    'readOnly' => true
                                ])?>
                            </td>
                        </tr>
                        <tr>
                            <td>Materials Fee</td>
                            <td><?= $form->field($model, 'MaterialsFee')->label(false)->textInput([
                                    'value' => 0,
                                    'readOnly' => true
                                ])?>
                            </td>
                        </tr>
                        <tr>
                            <td>Promo Code<br />(Type 'No' if you don't have one.)</td>
                            <td><?= $form->field($model, 'PromoCode')->label(false)->textInput([
                                    'placeholder' => 'e.g  ZF3HW4T'
                                ])?>
                            </td>
                        </tr>
                        <tr>
                            <td>Student Visa</td>
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
                            <td>Final Price ( US Dollars )</td>
                            <td>
                                <?= $form->field($model, 'finalPrice')->label(false)->textInput([
                                    'value' => 0,
                                    'readOnly' => true
                                ]); ?>
                            </td>
                        </tr>  
                    </table>
                    
                    <?= $form->field($model, 'message')->textarea(['rows' => 3]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>
                    
                    <?= $form->field($model, 'legal')->checkbox() ?> 

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button', 'id'=> 'signupSubmitBtn', 'disabled' => true]) ?>
                    </div>

                <?php ActiveForm::end(); ?>
                <a href="/site/legal" target=_blank>Click here to check our legal terms.</a>
            </div>
        </div>

    <?php endif; ?>
</div>
