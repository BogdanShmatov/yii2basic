<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Course;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\ClientHelper;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends Controller
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
        $courses =  ClientHelper::getInfo('GET', 'course');
        return $this->render('index',['courses'=>$courses]);
    }

    /**
     * Displays a single Course model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $course = ClientHelper::getInfo('GET', 'course/'.$id);
        return $this->render('view', [
            'course' => $course,
        ]);
    }

    /**
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Course();

        return $this->render('create', [
            'model' => $model,
        ]);


    }

    public function actionCreateCourse()
    {
        $model = new Course();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // Если пришёл AJAX запрос
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            // Получаем данные модели из запроса
            ClientHelper::getInfo('POST', $data);
            if ($model->load($data)) {
                return $this->redirect(['index']);
            } else {
                // Если это не AJAX запрос, отправляем ответ с сообщением об ошибке
                return [
                    "data" => null,
                    "error" => "error2"
                ];

            }
        }


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
        $model = new Course();
        $course = ClientHelper::getInfo('GET', 'course/'.$id);
        $data = Yii::$app->request->post();
        if ($model->load($data)) {
            $data['Course']['id'] = $course['id'];
            ClientHelper::getInfo('PUT', $data);

            return $this->redirect(['view', 'id' => $course['id']]);
        }

        return $this->render('update', [
            'course' => $course,
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
        ClientHelper::getInfo('DELETE', 'course/'.$id);

        return $this->redirect(['index']);
    }
}
