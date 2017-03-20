<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-guest">

    <?php $form = ActiveForm::begin([
        'id' => $postModel->formName(),
        'action' => ['post/subcom', 'id'=>$id, '#'=>'comments'],
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

<?php
$js = <<<JS
$('form#{$postModel->formName()}').on('beforeSubmit', function(e) {
   var \$form = $(this);
    $.ajax({
        url: \$form.attr('action'),
        type: 'post',
        data: \$form.serialize(),
        success: function (data) {
            \$('#msg').removeClass('hidden');
            \$('#comment-content').val('');
        }
    });
}).on('submit', function(e){
    e.preventDefault();
});
JS;
$this->registerJs($js);
?>