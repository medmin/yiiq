<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'orderid')->textInput(['maxlength' => true,'readOnly' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'readOnly' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true,'readOnly' => true]) ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 12,'readOnly' => true]) ?>

    <?= $form->field($model, 'service')->textInput(['maxlength' => true,'readOnly' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'createdAt')->textInput(['maxlength' => true,'readOnly' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['readOnly' => true]) ?>

    <?= $form->field($model, 'paidAt')->textInput(['maxlength' => true,'readOnly' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
