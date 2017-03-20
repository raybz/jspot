<?php 
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">

	<h3><a href="<?= $model->url;?>"><?= Html::encode($model->title)?></a></h3>
	<br/>
	<span class="glyphicon glyphicon-time"> <?= date('Y-m-d H:i:s',$model->create_time);?></span>&nbsp;&nbsp;&nbsp;
	<span class="glyphicon glyphicon-pencil"> <?= Html::encode($model->author->nickname);?></span>
	<?= HtmlPurifier::process($model->sub)?>
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