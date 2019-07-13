<?php

namespace frontend\controllers;

use Yii;
use app\models\Post;
use common\models\User;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
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

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
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
        if (\Yii::$app->user->can('createPost')) {
            $model = new Post();

            if ($model->load(Yii::$app->request->post())) {

                $userq = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
                $username = $userq['username'];
                $model->author = $username;
                $model->user_id = Yii::$app->user->identity->id;
                if ($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }

            return $this->render('create', [
                'model' => $model,
            ]);

        } else {
            return $this->redirect(['post/index']);
        }

    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (\Yii::$app->user->can('updatePost', ['user-id' => $model->user_id])) {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            throw new \yii\web\HttpException(403,'Oops. you can not edit or delete someone else post.');
        }


        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (\Yii::$app->user->can('updatePost', ['user-id' => $model->user_id])) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        else {
            throw new \yii\web\HttpException(403,'Oops. you can not edit or delete someone else post.');
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
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
