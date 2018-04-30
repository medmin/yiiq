<?php

namespace app\models;

use Yii;

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
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'email', 'name', 'msgbody', 'createdAt'], 'required'],
            [['type', 'createdAt'], 'integer'],
            [['msgbody'], 'string'],
            [['email', 'name'], 'string', 'max' => 100],
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
