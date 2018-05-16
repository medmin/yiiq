<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = $model->orderid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= 'Order ID: '.Html::encode($this->title) ?></h1>
    <!--
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'orderid',
            [
                'label' => 'name',
                'value' => str_replace("-"," ",$model->name)
            ],
            'email:email',
            'detail:html',
            'service',
            [
                'label' => 'price',
                'value' => $model->price . ' US Dollars, including 3% process fee'
            ],
            
            [
                'attribute' => 'createdAt',
                'value' => Yii::$app->formatter->asDate(round(($model->createdAt) / 1000), 'yyyy-MM-dd')
            ],
            [
                'label' => 'status',
                'value' => $model->status == 1 ? 'Paid' : 'Not Paid'
            ],
            [
                'label' => 'paidAt',
                'value' =>  $model->paidAt ==0 ? 0 : Yii::$app->formatter->asDate(round(($model->paidAt) / 1000), 'yyyy-MM-dd')
            ],
        ],
    ]) ?>

</div>
