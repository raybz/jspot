<?php
namespace backend\models;

use yii\base\Model;
use common\models\AdminUser;

/**
 * Signup form
 */
class ResetPassForm extends Model
{
    public $_user;
    public $oldpassword;
    public $password;
    public $repassword;
    public $id;

    // public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['id','oldpassword'], 'required'],
            ['id', 'number'],

            ['oldpassword', 'string', 'min' => 6],
            ['oldpassword', 'validatePassword'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['repassword', 'required'],
            ['repassword', 'compare', 'compareAttribute'=>'password', 'message' => 'twice password must be consitent'],


        ];
    }


    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->oldpassword)) {
                $this->addError($attribute, 'Incorrect oldpassword.');
            }
        }
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function resetpass($id)
    {
        if (!$this->validate()) {
            return false;
        } else {
            $user = Adminuser::findOne($id);
       
            $user->setPassword($this->password);
            $user->removePasswordResetToken();
            return $user->save() ? $user : null;
        }

    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = AdminUser::findIdentity($this->id);
        }

        return $this->_user;
    }
}
