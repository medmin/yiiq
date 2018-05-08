<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class PayController extends Controller
{
    public function actionStripecc()
    {
        $model = new PayForm();

        if ($model->load(Yii::$app->request->post()) && $model->stripecc())
        {

        }
    }
}