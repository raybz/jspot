<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Admin User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'nickname',
            // 'password',
            'email:email',
            // 'profile:ntext',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'<span style="width:20px;">{view}</span>
                <span style="width:20px;">{update}</span>
                <span style="width:20px;">{delete}</span>
                <span style="width:20px;">{reset-pass}</span>
                <span style="width:20px;">{privilege}</span>',
                'buttons'=> [
                    'reset-pass' => function($url, $model, $key){
                        $options = [
                            'title' => '审核1',
                            'aria-label' => '审核2',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-lock"></span>', $url, $options);
                    
                    },
                    'privilege' => function($url, $model, $key){
                        $options = [
                            'title' => '审核1',
                            'aria-label' => '审核2',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-time"></span>', $url, $options);
                    
                    },
                ]
            ],
        ],
    ]); ?>
</div>
