<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => 'http://qschool.edu',
        'options' => [
            'class' => 'navbar-pills navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            [
                'label' => 'Home', 
                'url' => 'http://qschool.edu'
            ],
            ['label' => 'About', 'url' => 'http://www.qschool.edu/about-us/'],
            ['label' => 'Contact', 'url' => 'http://www.qschool.edu/contact-student-services-representative/'],
            ['label' => 'Apply', 'url' => ['/site/apply']],
            [
                'label' => 'User',
                'items' => [
                    Yii::$app->user->isGuest ? (
                        ['label' => 'Login', 'url' => ['/site/login']]
                    ) : (
                        '<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            'Logout (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>'
                        ),
                    ['label' => 'Sign Up', 'url' => ['/site/signup'],'visible' => Yii::$app->user->isGuest],
                    !Yii::$app->user->isGuest ?  (
                        Yii::$app->user->identity->role <=2  ?
                        (['label' => 'Admin Dashboard', 'url' => ['/admin/index']]) : 
                        (['label' => 'My Dashboard', 'url' => ['/my/index']])
                    ) :  ("")
                ],
            ],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <a href="http://qschool.edu">QSchool.edu</a> All Rights Reserved <?= date('Y') ?></p>     
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
