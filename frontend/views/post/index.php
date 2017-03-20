<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use common\models\Post;
use yii\helpers\Url;
use yii\caching\DbDependency;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="post-index">
<?php Pjax::begin(['id' => 'po']) ?>
    <div class="col-md-9">
    
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_post',
        'layout' => '{items} {pager}',
        'pager' => [
            'maxButtonCount' => 10,
            'nextPageLabel' => 'next',
            'prevPageLabel' => 'prev'
        ]
    ])?>
    
    </div>
    
    <div class="col-md-3">

        <div class="searchbox">
            <ul class="list-group">
                <li class="list-group-item">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> 查找文章 
                    <?php 
                    //数据缓存
                    $data = Yii::$app->cache->get('postCount');
                    $dependency = new  DbDependency(['sql' => 'SELECT Count("id") FROM post where status= 2']);
/*                    $dependency = [  
                        'class' => 'yii\caching\DbDependency',  
                        'sql' => 'SELECT Count() FROM post where status= 2',  
                    ];  */
                    ?>
                    (
                    <?php 
                        if ($data === false) {
                            // sleep(2);
                            $data = Post::find()->where(['status'=>2])->count();
                            Yii::$app->cache->set('postCount', $data, 600, $dependency);
                        }
                        echo $data;
                    ?>
                    )
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
                <?php
                //数据片段缓存
                 if($this->beginCache('cache',['dependency' => $dependency])):?>                    
                <li class="list-group-item">
                <?php  sleep(2);?>
                    <?= \frontend\components\TagsWidget::widget(['tags'=>$tags])?>
                </li>
                <?php ($this->endCache()); endif;?>
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