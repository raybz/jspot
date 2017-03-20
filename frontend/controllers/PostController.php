<?php

namespace frontend\controllers;

use Yii;
use common\models\Post;
use common\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\Comment;
/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),//过滤器
                'rules' => [
                    [
                        'actions' => ['index', 'detail', 'view'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['subcom'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'pagecache' => [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 600,
                'variations' => [
                    Yii::$app->request->get('PostSearch'),
                    Yii::$app->request->get('page'),
                ],
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql' => 'select count("id") from post where status = 2',
                ],
            ],
            'httpcache' => [
                'class' => 'yii\filters\HttpCache',
                'only' => ['detail'],
                'lastModified' => function ($action, $params) {
                    return (new \yii\db\Query())->from('post')->max('update_time');
                },
                'etagSeed' => function ($action, $params) {
                    $post = $this->findModel(Yii::$app->request->get('id'));
                    return serialize([$post->title,$post->content]);
                },
                'cacheControlHeader' => 'public, max-age= 6600',
            ]
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $tags = \common\models\Tag::findTagWeight(20);
        // dump($tag);exit;
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tags'=> $tags,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionDetail($id)
    {
        $model = $this->findModel($id);
        $tags = \common\models\Tag::findTagWeight(20);


        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('details', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tags'=> $tags,
            'model' => $model,
        ]);
    }

    public function actionSubcom($id)
    {
        $userM = User::findOne(Yii::$app->user->id);
        
        $com = new Comment();
        if (Yii::$app->request->isAjax && $com->load(Yii::$app->request->post())) {
            $com->status = 1;
            $com->post_id = $id;
            $com->userid = $userM->id;
            $com->email = $userM->email;
            if($com->save()) {
                return true;
            } else {
                return ;
            }       
        }
    }


    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
