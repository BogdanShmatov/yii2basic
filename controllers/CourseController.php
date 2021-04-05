<?php

namespace app\controllers;

use Yii;
use app\models\BalanceEnroll;
use app\models\Comment;
use app\models\UserProgressCourse;
use app\models\Order;
use app\models\PayByBalance;
use app\models\User;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\helpers\ArrayHelper;
use app\common\helpers\ClientHelper;
use yii\data\ActiveDataProvider;

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
        $token = ClientHelper::authWooppay('test_merch','A12345678a');
        $data = [
            "service_name" => "test_merch_invoice",
            "reference_id" => time(),
            "amount" => $courses['course_price'],
            "merchant_name" => "test_merch",
            "request_url"=> "https://www.test.wooppay.com",
            "back_url"=> "http://academic/site/my/",
        ];
        $invoice  = ClientHelper::createInvoice('/invoice/create', $data, $token);
        $values = [
            'invoice_id' => $invoice['response']['invoice_id'],
            'key' => $invoice['response']['key'],
            'operation_id' => $invoice['response']['operation_id'],
            'course_id' => $courses['id']
        ];
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'invoice',
            'value' => $values,
        ]));
        $frame_url = $invoice['operation_url'];

        return $this->render('payByCard',[
            'course' => $courses,
            'invoice' => $invoice,
            'frame_url'=>$frame_url
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
        $balanceEnroll = BalanceEnroll::findAll(['user_id' => Yii::$app->user->getId()]);
        $course_id = ArrayHelper::getColumn($orders,'course_id');;
        $coursesName = [];

        foreach ($course_id as $i => $id) {
            $coursesName[$i] = ClientHelper::sendRequest('GET', 'course/' . $id . '?fields=course_name');
        }

        return $this->render('purchaseHistory', [
            'orders' => $orders,
            'coursesName' => $coursesName,
            'balanceEnroll' => $balanceEnroll
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