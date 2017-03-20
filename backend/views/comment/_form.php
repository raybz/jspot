<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\CommentStatus;
/* @var $this yii\web\View */
/* @var $model common\models\Comment */
/* @var $form yii\widgets\ActiveForm */
echo "<pre>";
        $a =CommentStatus::find()
        ->select(['name', 'id'])
        ->indexBy('id')
        ->one();
print_r($a);
echo "</pre>";
?>


<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropdownList(
        CommentStatus::find()
        ->select(['name', 'id'])
        ->indexBy('id')
        ->orderBy('position')
        ->column()
    ) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
