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
                <?php $form = ActiveForm::begin(['action' =>['pay/stripecc'], 'id' => 'pay-form']); ?>
                    <?= $form->field($model, 'orderId')->textInput( 
                        ['readOnly' => true, 'value'=>Yii::$app->session->get('orderInfo')['id']]
                    ) ?>

                    <?= $form->field($model, 'ProgramPrice')->textInput( 
                        ['readOnly' => true, 'value'=>Yii::$app->session->get('orderInfo')['price']]
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
                                     
                           
                <div id="cc-info-form" style="display:none">
                    <?= $form->field($model, 'creditcardHoldersName')->textInput(['id'=>'cc-name']) ?>
                    <?= $form->field($model, 'creditcardNumber')->textInput(['id'=>'cc-number']) ?>
                    <div class="row">
                        <div class="col-md-4"><?= $form->field($model, 'creditcardExpireMonth', ['inputOptions' =>['id'=>'cc-expire-mo']])->input('Number') ?></div>
                        <div class="col-md-4"><?= $form->field($model, 'creditcardExpireYear', ['inputOptions' =>['id'=>'cc-expire-yr']])->input('Number') ?></div>
                        <div class="col-md-4"><?= $form->field($model, 'creditcardCVV', ['inputOptions' => ['id'=>'cc-cvv']])->input('Number') ?></div>
                    </div>
                    
                </div>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                   <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'pay-button', 'id'=>'PayPageSubmitBtn']) ?>
                    </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>

    
</div>
