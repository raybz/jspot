<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\AdminUser;

/**
 * Login form
 */
class MenuForm extends Model
{
    public $name;
    public $pid;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

}
