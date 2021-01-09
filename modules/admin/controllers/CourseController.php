<?php

namespace app\modules\admin\controllers;

use app\models\Lesson;
use app\models\Model;
use Yii;
use app\models\Course;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
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
        $coursesAll =  ClientHelper::sendRequest('GET', 'course?expand=user_id');
        if (Yii::$app->user->can('updateCourse')) {
            return $this->render('index',['courses'=>$coursesAll]);
        }

        $courses = [];
        foreach ($coursesAll as $i => $course) {
            if ($course['user_id'] == Yii::$app->user->getId()) {
                $courses[$i] = $course;
            }

        }
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

        $course = ClientHelper::sendRequest('GET', 'course/'.$id);

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
        $categories = ClientHelper::sendRequest('GET', 'category');

        // Если пришёл AJAX запрос
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            // Получаем данные модели из запроса

            if ($model->load(Yii::$app->request->post())) {
                $data = [
                    'course_name' =>  $model->course_name,
                    'cat_id' =>  $model->cat_id,
                    'course_author' =>  $model->course_author,
                    'course_img_url' =>  $model->course_img_url,
                    'course_video_url' =>  $model->course_video_url,
                    'course_description' =>  $model->course_description,
                    'course_price' =>  $model->course_price,
                    'course_preview' =>  $model->course_preview,
                    'course_isFree' =>  $model->course_isFree,
                    'user_id' => Yii::$app->user->getId(),
                ];
                $data2 = Yii::$app->request->post();
                $lessons = $data2['Lesson'];

                $respCreateCourse = ClientHelper::sendRequest('POST','course', $data);
                    for ($i = 0, $size = count($lessons); $i < $size; $i++){
                        $lessons[$i]['course_id'] = $respCreateCourse['id'];
                        ClientHelper::sendRequest('POST','lesson', $lessons[$i]);
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

        $lessons = ClientHelper::sendRequest('GET', 'lesson?course_id='.$id);
        $course = ClientHelper::sendRequest('GET', 'course/'.$id.'?expand=user_id');
        $categories = ClientHelper::sendRequest('GET', 'category');

        if (!($course['user_id'] == Yii::$app->user->getId()) && !Yii::$app->user->can('admin')) {
            throw new ForbiddenHttpException("Хм... Нет доступа!");
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->id = $course['id'];

            $data = [
                'course_name' =>  $model->course_name,
                'cat_id' =>  $model->cat_id,
                'course_author' =>  $model->course_author,
                'course_img_url' =>  $model->course_img_url,
                'course_video_url' =>  $model->course_video_url,
                'course_description' =>  $model->course_description,
                'course_price' =>  $model->course_price,
                'course_preview' =>  $model->course_preview,
                'course_isFree' =>  $model->course_isFree,
            ];

            ClientHelper::sendRequest('PUT','course/'.$id, $data);

            return $this->redirect(['view', 'id' => $course['id']]);
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
       $course = ClientHelper::sendRequest('GET', 'course/'.$id.'?expand=user_id');

            if (!($course['user_id'] == Yii::$app->user->getId()) && !Yii::$app->user->can('admin')) {
            throw new ForbiddenHttpException("Хм... Нет доступа!");
        }

        ClientHelper::sendRequest('DELETE', 'course/'.$id);

        return $this->redirect(['index']);
    }

}
