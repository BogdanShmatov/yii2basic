<?php

namespace app\modules\admin\controllers;

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
        $categories =  ClientHelper::getInfo('GET', 'category');

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
        $category =  ClientHelper::getInfo('GET', 'category/'.$id);

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

        if ($model->load(Yii::$app->request->post()))
        {
            $data = Yii::$app->request->post();
            ClientHelper::postCategory('POST',$data);
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
        $category =  ClientHelper::getInfo('GET', 'category/'.$id);
        $data = Yii::$app->request->post();

        if ($model->load($data)) {
            $data['Category']['id'] = $category['id'];
            ClientHelper::postCategory('PUT', $data);

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
        ClientHelper::getInfo('DELETE', 'category/'.$id);

        return $this->redirect(['index']);
    }

}
