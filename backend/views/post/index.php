<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\poststatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            [
                'attribute' => 'authorName',
                'value'=>'author.nickname',
            ],
            // 'content:ntext',
            'tags:ntext',
            // 'status',
            [
                'attribute'=>'status',
                'value'=>'status0.name',
                'filter'=> Poststatus::find()
                    ->select(['name', 'id'])
                    ->orderBy('position')
                    ->indexBy('id')
                    ->column(),                
            ],
            // 'create_time:datetime',
            [
                'attribute'=>'update_time',
                'format'=>['date', 'php:Y-m-d H:i:s']
            ],
            // 'update_time:datetime',
            // 'author_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>