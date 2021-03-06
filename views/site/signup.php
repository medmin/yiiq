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
<div class="site-signup">
    <div class="text-center">
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Sign Up QSchool</h1>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

            <?= $form
                ->field($model, 'username', $fieldOptions('user'))
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('username') ])
            ?>
            <?= $form
                ->field($model, 'email', $fieldOptions('envelope'))
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('email') ])
            ?>
            <?= $form
                ->field($model, 'password', $fieldOptions('asterisk'))
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password') ])
            ?>
            <?= $form
                ->field($model, 'password2', $fieldOptions('asterisk'))
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password2') ])
            ?>
            <?= $form
                ->field($model, 'role')
                ->label(false)
                ->dropdownlist(
                    [
                        "PARENT" =>  "PARENT",
                        "STUDENT" => "STUDENT"
                    ],
                    ['prompt' => 'Who Am I?']
                )
            ?>



<!--            <div class="checkbox mb-3">-->
<!--                <label>-->
<!--                    <input type="checkbox" value="legal"> I agree with Term of Use-->
<!--                </label>-->
<!--            </div>-->
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
            <?php ActiveForm::end()?>
        </div>
    </div>
</div>