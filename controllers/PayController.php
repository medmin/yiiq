<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;


class PayController extends Controller
{
    public function actionStripe()
    {

        if (Yii::$app->request->post())
        {
            
            \Stripe\Stripe::setApiKey("sk_test_4FgKScuvjgJyynMBZR1S8c72");
            $token = Yii::$app->request->post('stripeToken');
            try
            {
                \Stripe\Charge::create([
                    'amount' => Yii::$app->request->post('PayForm')['ProgramPrice'] * 100,
                    'currency' => 'usd',
                    'description' => 'QSchool Language Program',
                    'source' => $token,
                ]);
                return $this->redirect('/');
            }
            catch (ErrorException $e)
            {
                return $this->render('site/error');
            }
            
        }
    }


}