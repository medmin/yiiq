<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ApplyForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use kartik\date\DatePicker;

$this->title = 'Apply Now';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php if (Yii::$app->session->hasFlash('ApplyFormSubmissionDbError')): ?>
        <div class="alert alert-warning">
            Thank you for applying. But it seems there is an error happened to our database. Please try again or email to us.
        </div>
    <?php elseif (Yii::$app->session->hasFlash('ApplyFormSubmissionLegalError')): ?>
        <div class="alert alert-warning">
            Thank you for applying. But it seems you have not agreed with the legal terms. Please try again and do check the checkbox. Thanks.
        </div>
    <?php else: ?>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'apply-form']); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'firstName')->textInput(['autofocus' => true]) ?>
                        </div>
                    
                        <div class="col-md-6">
                            <?= $form->field($model, 'familyName') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'dob')->widget(DatePicker::classname(), []) ?> 
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'gender')
                                    ->dropDownList(
                                        [
                                            'Male' => 'Male',
                                            'Female' => 'Female',
                                            'Other' => 'Other',
                                        ],
                                        ['prompt' => 'Choose a gender']
                                    )
                            
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                             <?= $form->field($model, 'email') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'phone') ?>
                        </div>
                    </div>
                    
                    <?= $form->field($model, 'homeAddress') ?>

                    <?= $form->field($model, 'howDoYouFindUs')
                            ->dropDownList(
                                [
                                    'Google' => 'Google',
                                    'OtherSearchEngine' => 'Search Engine in my country',
                                    'Agency' => 'Agency',
                                    'Facebook'=>'Facebook',
                                    'Instagram'=>'Instagram',
                                    'OtherSocialMedia'=>'Other Social Media',
                                    'Advertisement'=>'Advertisement',
                                ],
                                ['prompt' => 'How Do you find Us?']
                            )
                    ?>               

                    <?= $form->field($model, 'program')
                             ->dropDownList(
                                [
                                    'AcademicEnglish' => 'Academic English',
                                    'BusinessEnglish' => 'Business English',
                                    'FundamentalEnglish' => 'Fundamental English',
                                    'GMAT'=>'GMAT',
                                    'GRE'=>'GRE',
                                    'IELTS'=>'IELTS',
                                    'TOEFL'=>'TOEFL',
                                ],
                                ['prompt' => 'Choose a Program']
                            )
                    ?>
                    <?= $form->field($model, 'howManyWeeks') ?> 

                    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <?= $form->field($model, 'legal')->checkbox(["he"=>"wordl"]) ?> 

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
