<?php

use yii\helpers\Html;
use yii\grid\GridView;
use  yii\grid\DataColumn;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\Order */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'orderid',
                'value' => function($model){
                    $orderid = $model->orderid;
                    return Html::a($orderid, ['order/view','id'=>$model->id], ['title' => 'Order Detail']);
                },
                'format' => 'raw'
            ],
            [
                'class' => DataColumn::className(), // this line is optional
                'attribute' => 'name',
                'format' => 'text',
                'label' => 'Name',
                'value' => function($model){
                    return str_replace("-", " ", $model->name) ;
                }
            ],
            'email:email',
            [
                'attribute' => 'detail',
                'format' => 'raw',
                'value' => function($model){
                    $detail = $model->detail;
                    if (strlen($detail) > 50){
                        $readmore = substr($detail, 0, 50);
                        return $readmore . Html::a('...read more...', ['order/view','id'=>$model->id], ['title' => 'Order Detail']);
                    }
                    else{
                        return $detail;
                    }
                }
            ],
            'service',
            'price',
            [
                'attribute' => 'createdAt',
                'value' => function($model){
                    $createdAt = $model->createdAt;
                    $dateForAdmin = date("d F Y H:i:s", round($createdAt/1000));
                    return $dateForAdmin;
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    $status = $model->status;
                    $map = [ 0 => 'Not Paid', 1 =>'Paid'];
                    return $map[$status];
                }

            ],
            [
                'attribute' => 'paidAt',
                'value' => function($model){
                    $paidAt = $model->paidAt;
                    $dateForAdmin = date("d F Y H:i:s", round($paidAt/1000));
                    return $dateForAdmin;
                }
            ],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
