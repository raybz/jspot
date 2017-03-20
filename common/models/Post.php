<?php

namespace common\models;

use Yii;
use common\models\Tag;
use yii\helpers\Html;
use common\models\Comment;
/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $author_id
 *
 * @property Comment[] $comments
 * @property Adminuser $author
 * @property Poststatus $status0
 */
class Post extends \yii\db\ActiveRecord
{
    public $_oldTags;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status', 'author_id'], 'required'],
            [['content', 'tags'], 'string'],
            [['status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Adminuser::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Poststatus::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'tags' => 'Tags',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id'])->where(['status'=> 2]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Adminuser::className(), ['id' => 'author_id']);
    }



    public function getSub()
    {
        return mb_substr($this->content, 0, 1024, 'utf-8');
    }

    public function getUrl()
    {
        return Yii::$app->urlManager->createUrl(
            ['post/detail','id'=> $this->id, 'title'=> $this->title]);
    }

    public function getTagLinks()
    {
        $links = [];
        foreach (Tag::str2arr($this->tags) as $tag) {
            $links[] = Html::a(Html::encode($tag), ['post/index', 'PostSearch[tags]'=> $tag]);
        }
        return $links;
    }

    public function getcommentCount()
    {
        return Comment::find()->where(['post_id' => $this->id, 'status' => 2])->count();
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Poststatus::className(), ['id' => 'status']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = time();
                $this->update_time = time();
            } else {
                $this->update_time = time();
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->_oldTags = $this->tags;
    }

    public function afterSave($insert, $changedAttribute)
    {
        parent::afterSave($insert, $changedAttribute);
        Tag::updateFrequercy($this->_oldTags, $this->tags);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        Tag::updateFrequercy($this->tags, '');
    }

    public static function getbubble()
    {
        return self::find()->where(['status' => '1'])->count();
    }
}
