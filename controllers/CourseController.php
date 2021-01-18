<?php

namespace app\controllers;

use phpDocumentor\Reflection\Types\Integer;
use Yii;
use app\models\Comment;
use app\models\UserProgressCourse;
use app\models\Order;
use app\models\PayByBalance;
use app\models\PayByCardForm;
use app\models\User;
use yii\helpers\ArrayHelper;
use app\common\helpers\ClientHelper;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class CourseController extends Controller
{
    public function init()
    {
        parent::init();
        $this->view->params['categories'] = ClientHelper::sendRequest('GET', 'category');
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
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

    public function actionGetCategories(int $id = null)
    {
            $categories = ClientHelper::sendRequest('GET', 'category');
            $courses = ClientHelper::sendRequest('GET', 'course');
            $userId = Yii::$app->user->getId();
            $courseUser = \app\models\CourseUser::findAll(['user_id' => $userId]);
            $courseUser = ArrayHelper::getColumn($courseUser, 'course_id');

            if (Yii::$app->request->isPjax) {
                $coursesCat = [];
                $id = (int) $id;
                    foreach ($courses as $i => $course) {
                        if ($course['cat_id'] === $id) {
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

        return $this->render('categories',[
            'categories'=>$categories,
            'coursesCat' => $courses,
            'userId' => $userId,
            'courseUser' => $courseUser
        ]);
    }

    public function actionView(int $id)
    {
        $courseSingle = ClientHelper::sendRequest('GET', 'course/'.$id.'?expand=lessons0');

            if (empty($courseSingle['id'])) {
                throw new BadRequestHttpException('Запрашиваемый ресурс не найден!');
            }

        $comment = new Comment();
        $query = Comment::find()->where(['course_id'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

            if ($comment->load(Yii::$app->request->post()) && $comment->validate()) {

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

    public function actionBuyCourse(int $id)
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

    public function actionPayByCard(int $id)
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

    public function actionPayByBalance(int $id)
    {

        $user = User::findIdentity(Yii::$app->user->getId());
        $course = ClientHelper::sendRequest('GET', 'course/'.$id);

        if (empty($course['id'])) {
            throw new BadRequestHttpException();
        }

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

        foreach($orders as $i => $order) {
            $course_id[$i] = $order['course_id'];
        }

        $coursesName = [];

        foreach ($course_id as $i => $id) {
            $coursesName[$i] = ClientHelper::sendRequest('GET', 'course/' . $id . '?fields=course_name');
        }

        return $this->render('purchaseHistory', [
            'orders' => $orders,
            'coursesName' => $coursesName
        ]);
    }

    public function actionContinueCourse(int $id)
    {

        $orders = Order::findAll(['user_id' => Yii::$app->user->getId(), 'course_id' => $id]);
        $ordersId = ArrayHelper::getColumn($orders,'course_id');

        if (!in_array($id,$ordersId)){
            throw new ForbiddenHttpException('Доступ к запрашиваемому ресурсу запрещен!');
        }

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
//Отправляю данные не с формы, модель не заполняется....
            //hidden inputs ACTIVEFORM!
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

    public function  actionDeleteProgress(int $id)
    {
        UserProgressCourse::deleteAll(['course_id'=>$id, 'user_id'=>Yii::$app->user->getId()]);

        return $this->redirect(['continue-course', 'id' => $id ]);
    }


}