<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdminUser */

$this->title = 'privilege';
$this->params['breadcrumbs'][] = ['label' => 'Admin Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $id, 'url' => ['view', 'id'=> $id]];
$this->params['breadcrumbs'][] = 'Update';
?>



<div class="adminuser-privilege-form">
	<?php $form = ActiveForm::begin();?>
	<?= Html::checkboxList('newPri', $currentPriArr,$allPriArr);?>
	<hr>

	<hr>
    <div class="form-group ">
	    <?= Html::submitButton('update' , ['class'=> 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end();?>
</div>
