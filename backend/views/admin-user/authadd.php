<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AuthMenu */
/* @var $form ActiveForm */
$this->title = 'Create Auth';
$this->params['breadcrumbs'][] = ['label' => 'Auth', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
添加角色
</button>

<!-- Modal -->
<?php $form = ActiveForm::begin(); ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
          </div>
          <div class="modal-body">
            <div class="authadd">
                <?= $form->field($model, 'pid')->dropDownList([1,2],['prompt'=>'请选择']) ?>
                <?= $form->field($model, 'name') ?>
            </div><!-- authadd -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
          </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php $form = ActiveForm::begin(); ?>
<?php foreach ($tree as $key => $value): ?> 
<?= Html::checkboxList('newPri', [], [1,2,3]);?>
<hr>    
<?php endforeach;?>

<?php ActiveForm::end(); ?>