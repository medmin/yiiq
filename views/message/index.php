<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\Message */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'value' => function($model){
                    $id = $model->id;
                    return Html::a($id, ['message/view','id'=>$model->id], ['title' => 'Message Detail']);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    $type = $model->type;
                    $map = [ 1 => 'Apply', 2 =>'Contact', 3 =>'Payment'];
                    return $map[$type];
                },
            ],
            'email:email',
            [
                'attribute' => 'name',
                'value' => function($model){
                    return str_replace("-", " ", $model->name);
                }
            ],
            [
                'attribute' => 'msgbody',
                'label' => 'Message Detail',
                'format' => 'raw',
                'value' => function($model){
                    $detail = $model->msgbody;
                    if (strlen($detail) > 20){
                        $readmore = substr($detail, 0, 20);
                        return $readmore . Html::a('...read more...', ['message/view','id'=>$model->id], ['title' => 'Order Detail']);
                    }
                    else{
                        return $detail;
                    }
                }
            ],
            [
                'attribute' => 'createdAt',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->createdAt, 'yyyy-MM-dd');
                },
            ]

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
