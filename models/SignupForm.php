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
    public $contact;
    public $eiv;
    public $role;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'trim'],
            [['username', 'email', 'password', 'cellPhone', 'repeatPassword'], 'required'],
            ['repeatPassword', 'compare', 'compareAttribute'=>'password', 'message' => Yii::t('app','The two passwords differ')],
            ['username', 'unique', 'targetAttribute' => 'userUsername', 'targetClass' => '\app\models\Users', 'message' => Yii::t('app','This username has already been taken')],
            ['username', 'string', 'min' => 2, 'max' => 16],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetAttribute' => 'userEmail', 'targetClass' => '\app\models\Users', 'message' => Yii::t('app','This email has already been taken')],
            ['password', 'string', 'min' => 6],
            ['cellPhone', 'match', 'pattern' => '/^1[3-9][0-9]{9}$/', 'message' => Yii::t('app', 'Incorrect phone number')], // 如有 11 和 12 开头的再更改
//            ['citizenID', 'unique', 'targetAttribute' => 'userCitizenID', 'targetClass' => '\app\models\Users', 'message' => Yii::t('app','This citizenID number has already been taken')],
            [['citizenID', 'organization', 'name', 'landLine', 'address', 'liaison', 'note'], 'default', 'value' => 'N/A'],
//            [['organization', 'name', 'cellPhone', 'landLine', 'address', 'liaison', 'note'], 'required'],
            [['organization', 'name', 'landLine', 'address', 'liaison', 'note'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'repeatPassword' => Yii::t('app', 'Repeat Password'),
            'citizenID' => Yii::t('app', 'Citizen Id'),
            'organization' => Yii::t('app', 'Organization'),
            'name' => Yii::t('app', 'Name'),
            'landLine' => Yii::t('app', 'Land Line'),
            'cellPhone' => Yii::t('app', 'Cell Phone'),
            'address' => Yii::t('app', 'Address')
        ];
    }

    /**
     * Signs user up.
     *
     * @return Users|null the saved model or null if saving fails
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
        $user->eiv = false;
        $user->role = User::ROLE[$this->role];
        $timeArr = explode(" ", microtime());
        $user->createdAt =  round( ((int)$timeArr[1] + $timeArr[0]) * 1000  );
        $user->updatedAt = $user->createdAt;
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}