<?php

namespace app\controllers;

use Yii;
use app\models\Message;
use app\models\MessageSearch;
use app\models\User;
use yii\web\Controller;

class AdminController extends Controller
{

    // public function behaviors()
    // {
    //     return [
    //         [
    //             /**
    //              * 这里需要你来写，就是说，不是admin的不准看，不准看
    //              * admin的条件： eiv == 1 && roel <=2 
    //              * 本来想写在app\models\User里，但我发现不对
    //              */
                
    //         ],
    //     ];
    // }

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
