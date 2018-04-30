<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */

$this->title = 'Sign Up QSchool';

$fieldOptions = function($icon){
    return [
        'options' => ['class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<span class='glyphicon glyphicon-" . $icon . " form-control-feedback'></span>"
    ];
};

?>
<div class="container">
    <div class="text-center">
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Sign Up QSchool</h1>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions('user'))
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username') ]) 
            ?>
        <?= $form
            ->field($model, 'email', $fieldOptions('email'))
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('email') ]) 
            ?>
        <?= $form
            ->field($model, 'password', $fieldOptions('password'))
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('password') ]) 
            ?>
        <?= $form
            ->field($model, 'password2', $fieldOptions('password'))
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('password2') ])
            ?>



        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="legal"> I agree with Term of Use
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
    <?php ActiveForm::end()?>  
</div>