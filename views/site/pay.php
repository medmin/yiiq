<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\PayForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Alert;

$this->title = 'Pay';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("
$('#service-yesOrNo-checkbox').on('change', function(){
    var displayStatus = this.checked ? 'display:true;': 'display:none;' ;
    $('#service-details').attr('style', displayStatus);
});


$('#payment-method-id').on('change', function(){
    var methodValue = $(this).val();
    if (methodValue === 'cc'){
        $('#cc-info-form').attr('style', 'display:true;');
    }
    else{
        $('#cc-info-form').attr('style', 'display:none;');
    }
});

var stripe = Stripe('pk_test_JZsQOO0P2qAeeMHWoYKjlufi');
var elements = stripe.elements();
var style = {
    base: {
      // Add your base input styles here. For example:
      fontSize: '20px',
      color: '#32325d',
    }
  };
// Create an instance of the card Element.
var card = elements.create('card', {style:style});

// Add an instance of the card Element into the [cc-info-form] <div>.
card.mount('#cc-info-form');

card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
      displayError.textContent = event.error.message;
    } else {
      displayError.textContent = '';
    }
  });

  // Create a token or display an error when the form is submitted.
var form = document.getElementById('pay-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the customer that there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('pay-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
  
    // Submit the form
    form.submit();
  }

");

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->has('orderInfo')): ?>
        
        <?= Alert::widget([
            'options' => ['class' => 'alert-info'],
            'body' => 'Thank you for applying. Please finish the following payment process in 60 minutes. <br />' .Yii::$app->session->get('orderInfo')['msg'],
            ]); ?>
        

    <?php elseif (Yii::$app->session->hasFlash('PayFormSubmissionSuccess')): ?>
        <div class="alert alert-success">
            Welcome to the United States! And enjoy your time in the beatiful San Diego!
        </div>
    <?php elseif (Yii::$app->session->hasFlash('PayFormSubmissionError')): ?>
        <div class="alert alert-warning">
            Thank you, but it seems there is an error. Please try again. Thanks.
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <?php $form = ActiveForm::begin(['action' =>['pay/stripe'], 'id' => 'pay-form']); ?>
                    <?= $form->field($model, 'orderId')->textInput( 
                        [
                            // 'readOnly' => true, 
                            'value'=>Yii::$app->session->get('orderInfo')['id']
                        ]
                    ) ?>

                    <?= $form->field($model, 'ProgramPrice')->textInput( 
                        [
                            // 'readOnly' => true, 
                            'value'=>Yii::$app->session->get('orderInfo')['price']
                        ]
                    ) ?>
                   <?= $form->field($model, 'PaymentMethod')->dropdownlist(
                       [
                           'cc' => 'Credit Card',
                       ],
                       [
                           'prompt' => 'Please select a payment method',
                           'id'=> 'payment-method-id'
                        ]
                
                   ) ?>
                                     
                           
                <div id="cc-info-form" style="display:none" class="pt-2">
                    
                </div>
                <!-- Used to display Element errors. -->
                <div id="card-errors" role="alert" class="pt-1"></div>
                <?= $form->field($model, 'verifyCode')->label(false)->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                   <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'pay-button', 'id'=>'PayPageSubmitBtn']) ?>
                    </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>

    
</div>
