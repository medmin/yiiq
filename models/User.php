<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $contact
 * @property string $password
 * @property int $eiv
 * @property int $role 
 * @property string $authKey
 * @property string $accessToken
 * @property string $createdAt 13 digital timestamp
 * @property string $updatedAt 13 digital timestamp
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    const ROLE = [
        "BOSS" => 1,
        "MANAGER" => 2,
        "STAFF" => 3,
        "PARENT" =>  4,
        "STUDENT" => 5,
        "DEMO" => 99
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['contact'], 'string'],
            ['role', 'in', 'range' => [self::ROLE['PARENT'],self::ROLE['STUDENT']]], // 这个地方限制一下可注册的权限，可以使用scenarios
            [['username'], 'string', 'max' => 40],
            [['email'], 'string', 'max' => 100],
            [['username', 'email'], 'unique', 'targetAttribute' => ['username', 'email']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'contact' => Yii::t('app', 'Contact'),
            'password' => Yii::t('app', 'Password'),
            'eiv' => Yii::t('app', 'Eiv'),
            'role' => Yii::t('app', 'Role'), 
            'authKey' => Yii::t('app', 'Auth Key'),
            'accessToken' => Yii::t('app', 'Access Token'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createdAt', 'updatedAt'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updatedAt'
                ],
                'value' => function ($e) {
                    return round(microtime(true) * 1000);
                }
            ]
        ];
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Find user by email
     *
     * @param  string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Find user by username
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }


    // Implement methods in IdentityInterface
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findByLogin($login)
    {
         return filter_var($login, FILTER_VALIDATE_EMAIL) ? User::findByEmail($login) : User::findByUsername($login);
    }

}
