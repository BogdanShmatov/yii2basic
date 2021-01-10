<?php

namespace app\modules\admin\controllers;

use app\models\User;
use Yii;
use app\models\Category;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\ClientHelper;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CategoryController extends Controller
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
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex()
    {
        $categories =  ClientHelper::sendRequest('GET', 'category');

        return $this->render('index',['categories'=>$categories]);
    }

    /**
     * Displays a single Course model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $category =  ClientHelper::sendRequest('GET', 'category/'.$id);

        return $this->render('view', ['category' => $category]);
    }

    /**
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();
        $user = User::findOne(Yii::$app->user->getId());
        $accessToken = $user->auth_key;
        if ($model->load(Yii::$app->request->post()))
        {
            $category['cat_name'] = $model->cat_name;
            ClientHelper::sendRequest('POST','category', $category, $accessToken);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Course model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new Category();
        $category =  ClientHelper::sendRequest('GET', 'category/'.$id);
        $user = User::findOne(Yii::$app->user->getId());
        $accessToken = $user->auth_key;
        if ($model->load(Yii::$app->request->post())) {
            $cat = ['cat_name' => $model->cat_name];
            ClientHelper::sendRequest('PUT','category/'. $id, $cat, $accessToken);

            return $this->redirect(['view', 'id' => $category['id']]);
        }

        return $this->render('update', [
            'category' => $category,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Course model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $user = User::findOne(Yii::$app->user->getId());
        $accessToken = $user->auth_key;
        ClientHelper::sendRequest('DELETE', 'category/'.$id, '', $accessToken );

        return $this->redirect(['index']);
    }

}
