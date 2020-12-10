<?php

namespace app\modules\admin\controllers;

use app\models\Lesson;
use app\models\Model;
use Yii;
use app\models\Course;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\ClientHelper;
use yii\web\Response;

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
        $modelsLessons = [new Lesson()];
        $categories = ClientHelper::getInfo('GET', 'category');

        // Если пришёл AJAX запрос
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $lessons = $data['Lesson'];
            // Получаем данные модели из запроса

            if ($model->load($data)) {
                $respCreateCourse = ClientHelper::getInfo('POST', $data);
                    for ($i = 0, $size = count($lessons); $i < $size; $i++){
                        $lessons[$i]['course_id'] = $respCreateCourse['id'];
                        ClientHelper::postLesson('POST', $lessons[$i]);
                    }
                    Yii::$app->session->setFlash('success', 'Данные успешно сохранены ;)');

                    return $this->redirect(['index']);
                }
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
            'modelsLessons' => (empty($modelsLessons) )? [new Lesson()] : $modelsLessons
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
        $model = new Course();
        $modelsLessons = [new Lesson()];

        $lessons = ClientHelper::postLesson('GET', $id);
        $course = ClientHelper::getInfo('GET', 'course/'.$id);
        $categories = ClientHelper::getInfo('GET', 'category');
        $data = Yii::$app->request->post();

        if ($model->load($data)) {
            $data['Course']['id'] = $course['id'];
//            ClientHelper::getInfo('PUT', $data);

//            return $this->redirect(['view', 'id' => $course['id']]);
            var_dump($data);die();
        }

        return $this->render('update', [
            'categories' => $categories,
            'course' => $course,
            'model' => $model,
            'modelsLessons' => $modelsLessons,
            'lessons' => $lessons
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
