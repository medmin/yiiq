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
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('ApplyFormSubmissionSuccess')): ?>
        <div class="alert alert-success">
            Thank you for applying. Please finish the following payment process in 60 minutes.
        </div>
        <?= Alert::widget([
            'options' => ['class' => 'alert-info'],
            'body' => Yii::$app->session->get('orderId')['msg'],
            ]); ?>
        

    <?php elseif (Yii::$app->session->hasFlash('PayFormSubmissionSuccess')): ?>
        <div class="alert alert-success">
            Welcome to the United States! And enjoy your time in the beatiful San Diego!
        </div>
    <?php elseif (Yii::$app->session->hasFlash('PayFormSubmissionError')): ?>
        <div class="alert alert-warning">
            Thank you, but it seems there is an error. Please try again. Thanks.
        </div>
    <?php else: ?>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'pay-form']); ?>

                   

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
