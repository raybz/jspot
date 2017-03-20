<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-guest">

    <?php $form = ActiveForm::begin([
        'action' => ['post/detail', 'id'=>$id, '#'=>'comments'],
        'method' => 'post',
    ]); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($postModel, 'content')
                    ->textarea(['rows'=>3])
                    ->label('评论提交') 
            ?>
        </div>
    </div>
    

    <div class="form-group">
        <?= Html::submitButton('submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>