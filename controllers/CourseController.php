<?php

namespace app\controllers;

use Yii;
use app\models\Comment;
use app\models\UserProgressCourse;
use app\models\Order;
use app\models\PayByBalance;
use app\models\PayByCardForm;
use app\models\User;
use yii\helpers\ArrayHelper;
use app\helpers\ClientHelper;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class CourseController extends Controller
{
    public function init()
    {
        parent::init();
        $this->view->params['categories'] = ClientHelper::sendRequest('GET', 'category');

    }

    public function actionGetCourses()
    {
        $userId = Yii::$app->user->getId();
        $courses = ClientHelper::sendRequest('GET', 'course');
        $courseUser = \app\models\CourseUser::findAll(['user_id' => $userId]);
        $courseUser = ArrayHelper::getColumn($courseUser, 'course_id');

        return $this->render('courses',[
            'courses'=>$courses,
            'courseUser' => $courseUser,
            'userId' => $userId

        ]);
    }

    public function actionGetCategories($id = 2)
    {
        $categories = ClientHelper::sendRequest('GET', 'category');
        $courses = ClientHelper::sendRequest('GET', 'course');
        $coursesCat = [];
        $userId = Yii::$app->user->getId();
        $courseUser = \app\models\CourseUser::findAll(['user_id' => $userId]);
        $courseUser = ArrayHelper::getColumn($courseUser, 'course_id');
        foreach ($courses as $i => $course) {
            if ($course['cat_id'] == $id) {
               $coursesCat[$i] = $course;
            }

        }
        return $this->render('categories',[
            'categories'=>$categories,
            'coursesCat' => $coursesCat,
            'userId' => $userId,
            'courseUser' => $courseUser
        ]);
    }

    public function actionView($id)
    {
        $courseSingle = ClientHelper::sendRequest('GET', 'course/'.$id.'?expand=lessons0');
        $comment = new Comment();
        $query = Comment::find()->where(['course_id'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],

        ]);

        if ($comment->load(Yii::$app->request->post())) {

            $comment->course_id = $id;
            $comment->user_id = Yii::$app->user->getId();
            $comment->created_at = gmdate("Y-m-d H:i:s");
            $comment->updated_at = gmdate("Y-m-d H:i:s");
            if ( $comment->save()) {
                return $this->render('singleCourse',[
                    'courseSingle' => $courseSingle,
                    'listDataProvider' => $dataProvider,
                    'comment' => $comment
                ]);
            }
        }

        return $this->render('singleCourse',[
            'courseSingle' => $courseSingle,
            'listDataProvider' => $dataProvider,
            'comment' => $comment
        ]);
    }

    public function actionBuyCourse($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $courses = ClientHelper::sendRequest('GET', 'course/'.$id);

        if ($courses['course_isFree']) {

            $payment = new PayByBalance();
            $user = User::findIdentity(Yii::$app->user->getId());
            if ($payment->createOrder($courses , $user)) {

                return $this->redirect(['site/my']);
            }
        }
        return $this->render('buyCourse',[
            'course' => $courses
        ]);

    }

    public function actionPayByCard($id)
    {
        $courses = ClientHelper::sendRequest('GET', 'course/'.$id);
        $model = new PayByCardForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->createNewOrder($courses)) {

                return $this->redirect(['site/my']);

        }

        return $this->render('payByCard',[
            'course' => $courses,
            'model' => $model
        ]);
    }

    public function actionPayByBalance($id, $user_id)
    {
        $user = User::findIdentity($user_id);
        $course = ClientHelper::sendRequest('GET', 'course/'.$id);
        $model = new PayByBalance();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->createOrder($course , $user)) {

            return $this->redirect(['site/my']);
        }

        return $this->render('payByBalance',[
            'course' => $course,
            'user' => $user,
            'model' => $model
        ]);
    }

    public function actionGetPurchaseHistory()
    {
        $orders = Order::findAll(['user_id' => Yii::$app->user->getId()]);

        $course_id = [];
        for ($i = 0, $size = count($orders); $i < $size; $i++) {
            $course_id[$i] = $orders[$i]['course_id'];
        }
        $coursesName = [];
        for ($i = 0, $size = count($course_id); $i < $size; $i++) {
            $coursesName[$i] = ClientHelper::sendRequest('GET', 'course/' . $course_id[$i] . '?fields=course_name');
        }

        return $this->render('purchaseHistory', [
            'orders' => $orders,
            'coursesName' => $coursesName
        ]);
    }

    public function actionContinueCourse($id)
    {
        $courseSingle = ClientHelper::sendRequest('GET', 'course/'.$id.'?expand=lessons0');
        $coursesProgress = UserProgressCourse::findAll(['course_id'=>$id, 'user_id' => Yii::$app->user->getId()]);
        $progress = ArrayHelper::getColumn($coursesProgress, 'lesson_id');
        return $this->render('continueCourse',[
            'courseSingle' => $courseSingle,
            'progress' => $progress
        ]);
    }

    public function actionSaveProgress()
    {
        $model = new UserProgressCourse();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $data = Yii::$app->request->post();

            if ($data) {
                $model->course_id = $data['course_id'];
                $model->lesson_id = $data['lesson_id'];
                $model->user_id = Yii::$app->user->getId();
                if ($model->save() && $model->validate()) {
                    return 'Сохранено!';
                }
            }
        }
    }

    public function actionDeleteProgress($id)
    {
        UserProgressCourse::deleteAll(['course_id'=>$id, 'user_id'=>Yii::$app->user->getId()]);

        return $this->redirect(['continue-course', 'id' => $id ]);
    }


}