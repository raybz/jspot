<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Poststatus;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>
    <?php 
        // $obj = Poststatus::find()->all();
        // $obj = Yii::$app->db->createCommand('select id,name from poststatus')->queryAll();
        /* $obj = (new \yii\db\Query)->select(['id', 'name'])
                ->from('poststatus')
                ->indexBy('id')
                ->all();*/
        $obj = Poststatus::find()
                ->select(['id', 'name'])
                ->indexBy('id')
                ->all();
        $allStatus = ArrayHelper::map($obj, 'id', 'name');
    ?>

    <?= $form->field($model, 'status')
                ->dropDownList(
                    $allStatus,
                    ['prompt'=>'请选择状态'])
    ?>


    <?= $form->field($model, 'author_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>