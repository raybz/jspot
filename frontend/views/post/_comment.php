<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php 
foreach($comments as $comment):?>
<div class="comment">
	<div class="row">
		<div class="col-md-12">
			<div class="comment_detail">
				<em><span class="glyphicon glyphicon-globe"></span> <?= $comment->user->username;?> &nbsp;<span class="glyphicon glyphicon-time"></span>评论时间：<?= date('Y-m-d H:i:s', $comment->create_time);?>
	
				</em>

				<br>
				<?= nl2br($comment->content);?>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>