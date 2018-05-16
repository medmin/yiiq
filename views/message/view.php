<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = str_replace("-"," ",$model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-view">

    <h1><?= Html::encode($this->title) ?></h1>

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'type',
                'value' => function($model){
                    $type = $model->type;
                    $map = [ 1 => 'Apply', 2 =>'Contact', 3 =>'Payment'];
                    return $map[$type];
                }
            ],
            'email:email',
            [
                'label' => 'name',
                'value' => str_replace("-"," ",$model->name)
            ],
            'msgbody:html',
            [
                'attribute' => 'createdAt',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->createdAt, 'yyyy-MM-dd');
                },
            ]
        ],
    ]) ?>

</div>
