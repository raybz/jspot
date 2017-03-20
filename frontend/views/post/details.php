<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use common\models\Post;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="post-index">
<?php Pjax::begin(['id' => 'po1']) ?>
    <div class="col-md-9">
         <div class="post">

            <h3><a href="<?= $model->url;?>"><?= Html::encode($model->title)?></a></h3>
            <br/>
            <span class="glyphicon glyphicon-time"> <?= date('Y-m-d H:i:s',$model->create_time);?></span>&nbsp;&nbsp;&nbsp;
            <span class="glyphicon glyphicon-pencil"> <?= Html::encode($model->author->nickname);?></span>
            <?= HtmlPurifier::process($model->content)?>
            <br/>
            <div class="nav">
                <span class="glyphicon glyphicon-tags">
                    <?= implode(',', $model->tagLinks);?>
                </span>
                <br/>
                <?= Html::a("评论 ({$model->commentCount})", $model->url."#comments")?> | 最后修改时间：<?= date('Y-m-d H:i:s',$model->update_time);?>
            </div>
            <hr/>
            <br/>
        </div>
        <div class="common">
 
        <div class="alert alert-info hidden" id="msg" role="alert">
            <?= Html::a("<strong>Heads up!</strong> 评论已提交审核后可见", $model->url."#comments", ['name'=>'comments'])?>
        </div>

        <?php if ($model->commentCount >= 1): ?>
            <h5><?= $model->commentCount.'条评论。';?></h5>
            <?= $this->render('_comment', [
                'post' => $model,
                'comments' => $model->comments,
            ])?>
        <?php endif;?>
        <br/>
        <?php 
            $postComment = new \common\models\Comment();
            echo $this->render('_guest',[
                'id' => $model->id,
                'postModel' => $postComment,
                ]);
        ?>
        </div>   
    
    </div>
    
    <div class="col-md-3">

        <div class="searchbox">
            <ul class="list-group">
                <li class="list-group-item">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> 查找文章
                </li>                    
                <li class="list-group-item">
                    <form class="form-inline " action="<?= Url::to(['post/index'])?>" id= "w0" >
                        <div class="form-group">
                            <input class="form-control" style="width:150px;" type="text" id="w0input" name="PostSearch[title]" placeholder="搜索"/>
                            <button type="submit" class="btn btn-default">search</button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
        <div class="searchbox">
            <ul class="list-group">
                <li class="list-group-item">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> 查找文章
                </li>                    
                <li class="list-group-item">
                    <?= \frontend\components\TagsWidget::widget(['tags'=>$tags])?>
                </li>
            </ul>
        </div>
        <div class="searchbox">
            <ul class="list-group">
                <li class="list-group-item">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> 查找文章
                </li>                    
                <li class="list-group-item"> 搜索框</li>
            </ul>
        </div>
    </div>
    <?php Pjax::end()?>
</div>