<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommentStatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'content:ntext',
            [
                'attribute'=> 'content',
                'value'=>'Sub',
            ],
            // 'status',
            [
                'attribute' => 'status',
                'value' => 'status0.name',
                'filter'=> CommentStatus::find()
                            ->select(['name', 'id'])
                            ->orderBy('position')
                            ->indexBy('id')
                            ->column(),
                'contentOptions'=> function($model) {
                    return ($model->status ==1 )? ['class'=>'bg-danger']:[];
                }
            ],
            // 'create_time:datetime',
            [
                'attribute'=>'create_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            // 'userid',
            [
                'attribute' => 'userName',
                'value'=> 'user.username',
            ],
            // 'email:email',
            // 'url:url',
            // 'post_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'<span style="width:20px;">{view}</span>
                <span style="width:20px;">{update}</span>
                <span style="width:20px;">{delete}</span>
                <span style="width:20px;">{approve}</span>
                ',
                'buttons' =>[
                    'approve' => function($url, $model, $key) {
                        $options = [
                            'title' => '审核1',
                            'aria-label' => '审核2',
                            'data-confirm'=> '审核3',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return ($model->status==1)?Html::a('<span class="glyphicon glyphicon-check"></span>', $url, $options):'<span class="glyphicon glyphicon-check"></span>';
                    }
                ]
            ],
        
        ],
    ]); ?>
</div>
