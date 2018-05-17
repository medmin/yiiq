<?php

/**
 * @var $this yii\web\View 
 * @var $model2 app\models\Order
 * @var $model app\models\Message
 * */

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Admin Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-admin">
    <div class="box box-primary">
        <div class="box-header with-border"><h2>Orders</h2></div>
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider2,
                'filterModel' => $orderSearchModel,
                'columns' => [
                    [
                        'attribute' => 'orderid',
                        'value' => function($model2){
                            $orderid = $model2->orderid;
                            return Html::a($orderid, ['order/view','id'=>$model2->id], ['title' => 'Order Detail']);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'name',
                        'value' => function($model2){
                            return str_replace("-", " ", $model2->name);
                        }
                    ],
                    'email:email',
                    [
                        'attribute' => 'price'
                    ],
                    [
                        'attribute' => 'detail',
                        'format' => 'raw',
                        'value' => function($model2){
                            $detail = $model2->detail;
                            if (strlen($detail) > 50){
                                $readmore = substr($detail, 0, 50);
                                return $readmore . Html::a('...read more...', ['order/view','id'=>$model2->id], ['title' => 'Order Detail']);
                            }
                            else{
                                return $detail;
                            }
                        }
                    ],
                    [
                        'attribute' => 'createdAt',
                        'value' => function($model2){
                            $createdAt = $model2->createdAt;
                            $dateForAdmin = date("d F Y H:i:s", round($createdAt/1000));
                            return $dateForAdmin;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function($model2){
                            $status = $model2->status;
                            $map = [ 0 => 'Not Paid', 1 =>'Paid'];
                            return $map[$status];
                        }
                    ],
                    [
                        'attribute' => 'paidAt',
                        'value' => function($model2){
                            $paidAt = $model2->paidAt;
                            $dateForAdmin = date("d F Y H:i:s", round($paidAt/1000));
                            return $paidAt == 0 ? 0 : $dateForAdmin;
                        }
                    ],
                ]
            ]) ?>
        </div>
    </div>
    <hr />
    <div class="box box-primary">
        <div class="box-header with-border"><h2>Messages</h2></div>
        <div class="box-body table-responsive">
        <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $messageSearchModel,
                    'columns' => [
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
                            'value' => function($model){
                                $type = $model->type;
                                $map = [ 1 => 'Apply', 2 =>'Contact', 3 =>'Payment'];
                                return $map[$type];
                            }
                        ],
                        [
                            'attribute' => 'name',
                            'value' => function($model){
                                return str_replace("-", " ", $model->name);
                            }
                        ],
                        'email:email',
                        [
                            'attribute' => 'msgbody',
                            'format' => 'raw',
                            'value' => function($model){
                                $msgbody = $model->msgbody;
                                if (strlen($msgbody) > 20){
                                    $readmore = substr($msgbody, 0, 20);
                                    return $readmore . Html::a('...read more...', ['message/view','id'=>$model->id], ['title' => 'Message Detail']);
                                }
                                else{
                                    return $msgbody;
                                }
                            }
                        ],
                        [
                            'attribute' => 'createdAt',
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDate($model->createdAt, 'yyyy-MM-dd');
                            },
                        ]
                    ]
                ]); ?>
        </div>
    </div>
</div>