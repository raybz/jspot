<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdminUser */

$this->title = 'Create Admin User';
$this->params['breadcrumbs'][] = ['label' => 'Admin Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
// dump($model);exit;
?>
<div class="admin-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="admin-user-form">

	    <?php $form = ActiveForm::begin([
        'fieldConfig' => [  
            'template' => "{label}\n<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-3\"></div>\n

            <div class=\"col-lg-12\">
            <div class=\"col-lg-1\"></div><div class=\"col-lg-11\">{error}</div></div>",  
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
	    ]); ?>

	    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'password')->textInput(['type' => 'password']) ?>
	    
	    <?= $form->field($model, 'repassword')->textInput(['type' => 'password']) ?>

	    <?= $form->field($model, 'profile')->textarea(['rows' => 6]) ?>





	    <div class="form-group col-lg-12">
		    <div class="col-lg-8"></div>
		    <div class="col-lg-1">
		    	 <?= Html::submitButton('Create' , ['class'=> 'btn btn-success']) ?>
		    </div>
		    <div class="col-lg-3"></div>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>


