<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property string $id
 * @property string $orderid
 * @property string $name
 * @property string $email
 * @property string $detail
 * @property string $service
 * @property string $price
 * @property string $createdAt
 * @property int $status
 * @property string $paidAt
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderid', 'name', 'email', 'detail', 'price','createdAt'], 'required'],
            [['detail'], 'string'],
            [['price','createdAt', 'paidAt'], 'integer'],
            ['price', 'integer', 'min'=> 1],
            [['orderid'], 'string', 'max' => 25],
            [['name', 'email', 'service'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'orderid' => Yii::t('app', 'Orderid'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'detail' => Yii::t('app', 'Detail'),
            'service' => Yii::t('app', 'Service'),
            'price' => Yii::t('app', 'Price'),
            'createdAt' => Yii::t('app', 'Created At'),
            'status' => Yii::t('app', 'Status'),
            'paidAt' => Yii::t('app', 'Paid At'),
        ];
    }
}
