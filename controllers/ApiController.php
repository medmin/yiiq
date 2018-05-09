<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class ApiController extends Controller
{
    public function actionTest()
    {
        $data = Yii::$app->request->queryParams;
        if (!$data['promocode'])
        {
            return 'Empty';
        }
        return 'Full';
    }
}