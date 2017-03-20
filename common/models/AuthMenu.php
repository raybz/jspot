<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auth_menu".
 *
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property string $item_name
 * @property string $route
 * @property integer $order
 * @property integer $flag
 */
class AuthMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'order', 'flag'], 'integer'],
            [['name', 'item_name', 'route'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'pid' => 'Pid',
            'item_name' => 'Item Name',
            'route' => 'Route',
            'order' => 'Order',
            'flag' => 'Flag',
        ];
    }
}
