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
        <div class="box-header with-border"><p>Messages</p></div>
        <div class="box-body table-responsive">
        <?= GridView::widget([
                    'dataProvider' => $dataProvider,
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