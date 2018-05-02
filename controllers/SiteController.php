<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ApplyForm;
use app\models\SignupForm;
use app\models\PayForm;
use app\models\Order;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * sign up 
     */
    public function actionSignup()
    {
        //这里要跳转，如果已经登录，就根据ROLE来跳转
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $user = $model->signup()) {
            if (Yii::$app->getUser()->login($user)) {
                return $this->goHome();
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->contact() == 1)
            {
                Yii::$app->session->setFlash('ContactFormSubmissionSuccess');
            }
            else
            {
                Yii::$app->session->setFlash('ContactFormSubmissionError');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays apply page.
     *
     * @return string
     */
    public function actionApply()
    {
        $model = new ApplyForm();

        if ($model->load(Yii::$app->request->post())) 
        {

            if ($model->apply() == 1)
            {
                $session = Yii::$app->session;
                $session->setFlash('ApplyFormSubmissionSuccess');
                $ApplyMsg = $session->get('ApplyMsg');
                $orderId = "Q". date("Ymd") . crypt($ApplyMsg['Email'], Yii::$app->params['PayHashSalt']) . substr(microtime(), 0, 5) * 1000 ;
                $orderIdSessionMsg = "Please write down the <strong>order-id: " . $orderId ."</strong>. It's very important.";
                $orderIdSessionMsg .= '<br />And the price of the program you have chosen is ' . $ApplyMsg['Price'];
                /** store details into mysql 
                 * table is order
                */
                $orderModel = new Order();
                $orderModel->orderid = $orderId;
                $orderModel->name = $ApplyMsg['FirstName'] .'-'. $ApplyMsg['FamilyName'] ;
                $orderModel->email = $ApplyMsg['Email'];
                $orderModel->detail = implode("<br />", $ApplyMsg);
                $orderModel->price = $ApplyMsg['Price'];
                $orderModel->createdAt = substr(microtime(), 0, 5) * 1000 + substr(microtime(), 11, 10) * 1000;
                
                if ( $orderModel->save())
                {
                    $session['orderId'] = [
                        'msg' => $orderIdSessionMsg,
                        'id' => $orderId,
                        'detail' => $ApplyMsg,
                    ];
                    return $this->redirect('/site/pay');
                }
                else
                {
                    Yii::$app->session->setFlash('ApplyFormSubmissionDbError');
                }
                
            }

            elseif ($model->apply() == 0)
            {
                Yii::$app->session->setFlash('ApplyFormSubmissionDbError');
            }
            elseif ($model->apply() == -1)
            {
                Yii::$app->session->setFlash('ApplyFormSubmissionLegalError');
            }
            
            
            return $this->refresh();
        }
        return $this->render('apply', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionPay()
    {
        $model = new PayForm();
        return $this->render('pay',  [
            'model' => $model,
        ]);
    }

    


}
