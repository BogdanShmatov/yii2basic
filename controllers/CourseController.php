<?php

namespace app\controllers;

use app\models\Comment;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\models\Order;
use app\models\PayByBalance;
use app\models\PayByCardForm;
use app\models\User;
use app\helpers\ClientHelper;

class CourseController extends Controller
{
    public $categoriesMenu;

    public function init()
    {
        parent::init();
    }

    public function actionGetCourses()
    {
        $courses =  ClientHelper::getInfo('GET', 'course?expand=lessons0');

        return $this->render('courses',['courses'=>$courses]);
    }

    public function actionGetCategories($id = 2)
    {
        $categories = ClientHelper::postCategory('GET', 'category');
        $courses = ClientHelper::getInfo('GET', 'course');
        $coursesCat = [];

        foreach ($courses as $i => $course) {
            if ($course['cat_id'] == $id) {
               $coursesCat[$i] = $course;
            }
        }

        return $this->render('categories',[
            'categories'=>$categories,
            'coursesCat' => $coursesCat
        ]);
    }

    public function actionView($id)
    {
        $courseSingle = ClientHelper::getInfo('GET', 'course/'.$id.'?expand=lessons0');
        $comment = new Comment();
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()->where(['course_id'=>$id]),
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

        $courses = ClientHelper::getInfo('GET', 'course/'.$id);

        return $this->render('buyCourse',[
            'course' => $courses
        ]);

    }

    public function actionPayByCard($id)
    {
        $courses = ClientHelper::getInfo('GET', 'course/'.$id);
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
        $course = ClientHelper::getInfo('GET', 'course/'.$id);
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
        $coursesName = ClientHelper::getCoursesById($orders, '?fields=course_name');

        return $this->render('purchaseHistory', [
            'orders' => $orders,
            'coursesName' => $coursesName
        ]);
    }

    public function actionContinueCourse($id)
    {
        $courseSingle = ClientHelper::getInfo('GET', 'course/'.$id.'?expand=lessons0');

        return $this->render('continueCourse',[
            'courseSingle' => $courseSingle
        ]);
    }


}