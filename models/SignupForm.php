<?php
/**
 * User: Mr-mao
 * Date: 2017/7/24
 * Time: 12:06
 */

namespace app\models;

use yii\base\Model;
use Yii;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password2;
    public $contact = '';
    public $eiv = false;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'trim'],
            [['username', 'email', 'password', 'password2', 'role'], 'required'],
            ['password2', 'compare', 'compareAttribute'=>'password', 'message' => Yii::t('app','The two passwords differ')],
            ['username', 'unique', 'targetAttribute' => 'username', 'targetClass' => '\app\models\User', 'message' => Yii::t('app','This username has already been taken')],
            ['username', 'string', 'min' => 2, 'max' => 16],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => '\app\models\User', 'message' => Yii::t('app','This email has already been taken')],
            ['password', 'string', 'min' => 6]
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'password2' => Yii::t('app', 'Repeat Password Please'),
            'role' => Yii::t('app', 'Who Am I?'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        //没有通过验证，返回null
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = filter_var($this->email, FILTER_VALIDATE_EMAIL);
        $user->setPassword($this->password);
        $user->contact = $this->contact;
        $user->eiv = $this->eiv;
        $user->role = User::ROLE[$this->role];
        $user->createdAt =  round(microtime(true) * 1000);
        $user->updatedAt = $user->createdAt;
        $user->generateAuthKey();
        if ($user->save()) {
            return $user;
        } else {
            print_r($user->errors);exit;
        }
        return $user->save() ? $user : null;
    }
}