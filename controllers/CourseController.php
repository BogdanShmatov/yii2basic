<?php


namespace app\controllers;

use app\models\Order;
use Yii;

use app\models\PayByBalance;
use app\models\PayByCardForm;
use app\models\User;

use app\helpers\ClientHelper;



use yii\web\Controller;

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

    public function actionGetCategories()
    {
        $categories = ClientHelper::getInfo('GET', 'course?fields=cat');

        return $this->render('categories',['categories'=>$categories]);

    }

    public function actionView($id)
    {

        $courseSingle = ClientHelper::getInfo('GET', 'course/'.$id.'?expand=lessons0');

        return $this->render('singleCourse',['courseSingle' => $courseSingle]);
    }

    public function actionBuyCourse($id)
    {
        if (Yii::$app->user->isGuest) {

            return $this->redirect(['site/login']);

        }

        $courses = ClientHelper::getInfo('GET', 'course/'.$id);

        return $this->render('buyCourse',['course' => $courses]);

    }

    public function actionPayByCard($id)
    {
        $courses = ClientHelper::getInfo('GET', 'course/'.$id);

        $model = new PayByCardForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->createNewOrder($courses)) {

                return $this->redirect(['site/my']);

        }

        return $this->render('payByCard',['course' => $courses, 'model' => $model]);
    }

    public function actionPayByBalance($id, $user_id)
    {
        $user = User::findIdentity($user_id);

        $course = ClientHelper::getInfo('GET', 'course/'.$id);

        $model = new PayByBalance();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->createOrder($course , $user)) {

            return $this->redirect(['site/my']);
        }

        return $this->render('payByBalance',['course' => $course, 'user' => $user, 'model' => $model]);
    }

    public function actionGetPurchaseHistory()
    {
        $orders = Order::findAll(['user_id' => Yii::$app->user->getId()]);

        $coursesName = ClientHelper::getCoursesById($orders, '?fields=course_name');
        return $this->render('purchaseHistory', ['orders' => $orders, 'coursesName' => $coursesName]);
    }

    public function actionContinueCourse($id)
    {
        $courseSingle = ClientHelper::getInfo('GET', 'course/'.$id.'?expand=lessons0');

        return $this->render('continueCourse',['courseSingle' => $courseSingle]);
    }


}