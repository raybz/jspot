<?php
namespace backend\models;

use yii\base\Model;
use common\models\AdminUser;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $nickname;
    public $email;
    public $password;
    public $repassword;
    public $profile;
    // public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\AdminUser', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['nickname', 'required'],
            ['nickname', 'string', 'min' => 2, 'max' => 32],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\AdminUser', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['repassword', 'required'],
            ['repassword', 'compare', 'compareAttribute'=>'password', 'message' => 'twice password must be consitent'],

            ['profile', 'string'],

/*            ['verifyCode', 'required'],
            ['verifyCode', 'captcha', 'captchaAction'=>'admin-user/captcha', 'message' => 'captcha is wrong']*/
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }
        $user = new AdminUser();
        $user->username = $this->username;
        $user->nickname = $this->nickname;
        $user->email = $this->email;
        $user->profile = $this->profile;
        $user->password = '*';
        $user->setPassword($this->password);
        $user->generateAuthKey();

        // var_dump($user->error);
        return $user->save() ? $user : null;
    }
}
