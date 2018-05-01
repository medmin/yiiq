<?php

namespace app\controllers;

use Yii;
use app\models\Message;
use app\models\MessageSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class AdminController extends Controller
{

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        
        if (Yii::$app->user->identity->role <= 2 && Yii::$app->user->identity->eiv == 1) 
        {
            return true;
        }
        
        throw new ForbiddenHttpException('No Permission.');
    }

    public function actionIndex()
    {
        
        $messageSearchModel = new MessageSearch();
        $dataProvider = $messageSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('index',[
            'messageSearchModel' => $messageSearchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRecord()
    {
        //设置2个button，传递不同的参数，然后来区分是apply还是contact
        $messageSearchModel = new MessageSearch();
        $dataProvider = $messageSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('index',[
            'messageSearchModel' => $messageSearchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    //pay要区分下的订单，和已经支付的订单，或者默认仅显示支付成功的订单
    public function actionPay()
    {
        $messageSearchModel = new MessageSearch();
        $dataProvider = $messageSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('index',[
            'messageSearchModel' => $messageSearchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
