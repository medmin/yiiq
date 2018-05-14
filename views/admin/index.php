<?php

/**
 * @var $this yii\web\View 
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
                        'attribute' => 'orderid'
                    ],
                    [
                        'attribute' => 'name'
                    ],
                    [
                        'attribute' => 'email'
                    ],
                    [
                        'attribute' => 'detail',
                        'format' => 'raw'
                    ],
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
                            'attribute' => 'id'
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
                            'attribute' => 'name'
                        ],
                        [
                            'attribute' => 'email'
                        ],
                        [
                            'attribute' => 'msgbody',
                            'value' => function ($model) {
                                return Html::a($model->msgbody);
                            },
                            'format' => 'raw'
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