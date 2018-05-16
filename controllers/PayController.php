<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Order;


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
                $orderid = trim((string)(Yii::$app->request->post('PayForm')['orderId']));
                $order = Order::findOne(['orderid' => $orderid]);
                $order->status = 1;
                $order->paidAt = substr(microtime(), 0, 5) * 1000 + substr(microtime(), 11, 10) * 1000;
                return $order->save() ? $this->redirect('http://www.qschool.edu') : $this->redirect('/pay/error');
            }
            catch (ErrorException $e)
            {
                return $this->redirect('/pay/error');
            }
            
        }
    }


}