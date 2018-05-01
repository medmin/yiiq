<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "message".
 *
 * @property string $id
 * @property string $type
 * @property string $email
 * @property string $name
 * @property string $msgbody
 * @property string $createdAt
 */
class Message extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'createdAt',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'createdAt'
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'email', 'name', 'msgbody'], 'required'],
            [['type'], 'integer'],
            [['msgbody'], 'string'],
            [['email', 'name'], 'string', 'max' => 100],
            ['email', 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'email' => Yii::t('app', 'Email'),
            'name' => Yii::t('app', 'Name'),
            'msgbody' => Yii::t('app', 'Msgbody'),
            'createdAt' => Yii::t('app', 'Created At'),
        ];
    }
}
