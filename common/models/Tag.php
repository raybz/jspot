<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],
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
            'frequency' => 'Frequency',
        ];
    }

    public static function str2arr($tags)
    {
        if(empty($tags)) return ;
        return explode(',', $tags);
    }

    public static function arr2str($tags)
    {
        if(empty($tags)) return ;
        return implode(',', $tags);
    }

    public static function addTags($tags)
    {
        if(empty($tags)) return ;
        foreach ($tags as $name) {
            $aTag = Tag::find()
                    ->where(['name'=>$name])->one();
            $aTagCount = Tag::find()
                    ->where(['name'=>$name])->count();

            if (!$aTagCount) {
                $tag = new Tag;
                $tag->name = $name;
                $tag->frequency = 1;
                $tag->save();
            } else {
                $aTag->frequency += 1;
                $aTag->save(); 
            }
        }
    }

    public static function delTags($tags)
    {
        if(empty($tags)) return ;
        foreach ($tags as $name) {
            $dTag = Tag::find()
                    ->where(['name'=>$name])->one();
            $dTagCount = Tag::find()
                    ->where(['name'=>$name])->count();
            if ($dTagCount) {
                if ($dTagCount && $dTag->frequency <= 1) {
                    $dTag->delete();
                } else {
                    $dTag->frequency -= 1;
                    $dTag->save(); 
                }                
            }
        }
    }

    public static function updateFrequercy($oldTags, $newTags)
    {

        if (!empty($oldTags) || !empty($newTags))
        {
            $oldTagsArr = self::str2arr($oldTags);
            $newTagsArr = self::str2arr($newTags);

            self::addTags($newTagsArr);
            self::delTags($oldTagsArr);
        }
    }

    public static function findTagWeight($limit = 20)
    {
        $tag_size_level = 5;
        $models = Tag::find()
                    ->orderBy('frequency desc')->limit($limit)->all();
        $total = Tag::find()
                    ->limit($limit)->count();
        $stepper = ceil($total/$tag_size_level);
        $tags = [];
        $count = 1;
        if ($total > 0) {
            foreach ($models as $mod) {
                $weight = ceil($count/$stepper)+1;
                $tags[$mod->name] = $weight;
                $count++;
            }
            ksort($tags);
        }
        return $tags;
    }

}
