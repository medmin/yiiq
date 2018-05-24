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
use app\queues\NotifyAdminJob;


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
        $this->layout = "main-apply";

        $model = new ApplyForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->apply()) 
        {

            $session = Yii::$app->session->get('orderInfo');

            $id = $session['id'];

            Yii::$app->mailer->compose('notifyAdmin')
                    ->setFrom('technology@ieducationm.com')
                    ->setTo('alvinc@qschool.edu')
                    ->setSubject('Hello, OrderId: ' . $id)
                    ->send();

            // Yii::$app->queue->push(new NotifyAdminJob([
            //     'mailViewName' => 'notifyAdmin',
            //     'fromAddress' => 'technology@ieducationm.com',
            //     'toAddress' => 'guiyumin@gmail.com',
            //     'subject' => 'Hello, OrderId: ' . $id
            // ]));

            return $this->redirect('/site/applythankyou');
        }

        return $this->render('apply', [
            'model' => $model
        ]);
    }

    public function actionApplythankyou()
    {
        return $this->render('applythankyou');
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

    /**
     * Displays legal terms page.
     *
     * @return string
     */
    public function actionLegal()
    {
        return $this->render('legal');
    }



}
