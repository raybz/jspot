<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AuthMenu */
/* @var $form ActiveForm */
?>
<div class="authadd">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'pid') ?>
        <?= $form->field($model, 'order') ?>
        <?= $form->field($model, 'flag') ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'item_name') ?>
        <?= $form->field($model, 'route') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- authadd -->
