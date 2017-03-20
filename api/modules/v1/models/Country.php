<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

class Country extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }
    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }
    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required']
        ];
    }
}
