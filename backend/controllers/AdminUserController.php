<?php

namespace backend\controllers;

use Yii;
use common\models\AdminUser;
use common\models\AdminUserSearch;
use common\models\AuthItem;
use common\models\AuthAssignment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use backend\models\SignupForm;
use backend\models\ResetPassForm;

/**
 * AdminUserController implements the CRUD actions for AdminUser model.
 */
class AdminUserController extends Controller
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
        ];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Lists all AdminUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdminUser model.
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
     * Creates a new AdminUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                return $this->redirect(['index']);
            } else {
                dump($model);
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AdminUser model.
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
     * Deletes an existing AdminUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }



    public function actionResetPass()
    {
        $model = new ResetPassForm();

        if ($model->load(Yii::$app->request->post())  && $model->resetpass(Yii::$app->request->get('id'))) {
            return $this->redirect(['index']);
        } else {
            return $this->render('resetPass', [
                'model' => $model,
            ]);
        }
    }

    public function actionAuthAdd()
    {
        $model = new \backend\models\MenuForm();

        $mod = \common\models\AuthMenu::find()->where(['flag'=> 1])->asArray()->all();
        dump($mod);
/*        $tree = array();  
        foreach($mod as $category){  
            $tree[$category['id']] = $category;  
            $tree[$category['id']]['children'] = array();  
        }  
        foreach($tree as $key=>$item){  
            if($item['pid'] != 0){  
                $tree[$item['pid']]['children'][] = &$tree[$key];
                if($tree[$key]['children'] == null){  
                    unset($tree[$key]['children']); 
                }  
            }  
        }  
        foreach($tree as $key=>$category){  
            if($category['pid'] != 0){  
                unset($tree[$key]);  
            }  
        }*/ 
exit;
        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['index']);
        } else{
            return $this->render('authadd', ['model'=> $model, 'tree'=> $tree]);
        }
    }

    public function actionPrivilege($id)
    {
        $allPrivileges = AuthItem::find()->select(['name', 'type', 'description'])
                        // ->where(['>', 'type', 1])->orderBy('description')->all();
                        ->orderBy('type','description')->all();
        // dump($allPrivileges);exit;
        $allPriArr = [];
        foreach ($allPrivileges as $value) {
            $allPriArr[$value->name] = $value->description;
        }

        $currentPri = AuthAssignment::find()->select(['item_name'])
                    ->where(['user_id'=>$id])->all();
        $currentPriArr = [];
        foreach ($currentPri as $assign) {
            array_push($currentPriArr, $assign->item_name);
        }

        //*******************/
/*        $allChildPriArr = AuthItem::find()->select(['name', 'description'])->with('children')
                        ->where(['type'=>1])->orderBy('description')->asArray()->all();

        $allPris = [];
        foreach ($allChildPriArr as  $value) {
            if (isset($value['children']) && !empty($value['children'])) {
                foreach ($value['children'] as $key => $val) {
                    $child[$key]['name'] =  $val['name'];
                    $child[$key]['description'] =  $val['description'];

                }
                unset($value['children']);
                $value['children'] = $child;              
            }
            $allPris[] = $value;
        }*/

        //************************/
        $currentPri = AuthAssignment::find()->select(['item_name'])
                    ->where(['user_id'=>$id])->all();
        $currentPriArr = [];
        foreach ($currentPri as $assign) {
            array_push($currentPriArr, $assign->item_name);
        }
dump($currentPriArr);exit;
dump($allPris);
dump($currentPriArr);
dump($allPriArr);exit;
        if(isset($_POST['newPri'])) {
            AuthAssignment::deleteAll('user_id=:id',[':id'=> $id]);
            $newPri = Yii::$app->request->post('newPri');
            $arrlen = count($newPri);
            for ($i=0; $i < $arrlen; $i++) { 
                $aPri = new AuthAssignment();
                $aPri->item_name = $newPri[$i];
                $aPri->user_id = $id;
                $aPri->created_at = time();
                $aPri->save();
            }
            return $this->redirect(['index']);
        }

        // return $this->render('privilege', ['id'=>$id, 'allPriArr'=> $allPriArr, 'currentPriArr' => $currentPriArr]);
        return $this->render('privilege', ['id'=>$id, 'allPriArr'=> $allPris, 'currentPriArr' => $currentPriArr]);
    }








    /**
     * Finds the AdminUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
