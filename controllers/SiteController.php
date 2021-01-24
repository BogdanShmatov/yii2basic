<?php

namespace app\controllers;

use app\models\PayByCardForm;
use app\models\PersonalInfo;
use app\models\SliderImage;
use app\models\User;
use app\models\UserProgressCourse;
use Yii;
use app\common\helpers\ClientHelper;
use app\models\CourseUser;
use app\models\ResendVerificationEmailForm;
use mdm\admin\models\form\Signup as SignupForm;
use mdm\admin\models\form\Login  as LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\VerifyEmailForm;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\base\InvalidArgumentException;

class SiteController extends Controller
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

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],

                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $images = SliderImage::find()->all();
        return $this->render('index', ['images'=>$images]);
    }

    public function actionMy()
    {
        $cookies = Yii::$app->request->cookies;
        if (($cookie = $cookies->get('invoice')) !== null) {
            $values = $cookie->value;
            $invoice_id = $values['invoice_id'];
            $key = $values['key'];
            $course_id = $values['course_id'];
            $tpmCourseUser = CourseUser::findOne([
                'user_id' => Yii::$app->user->getId(),
                'course_id' => $course_id
            ]);
            if ($status = ClientHelper::checkInvoiceStatus($invoice_id, $key) && !$tpmCourseUser) {
                $course = ClientHelper::sendRequest('GET', 'course/'.$course_id);
                $model = new PayByCardForm();
                if ($model->createNewOrder($course, $values)) {
                    $cookies = Yii::$app->response->cookies;
                    $cookies->removeAll();
                    unset($values, $invoice_id, $key, $course_id, $cookie);
                }
            }
        }
        $coursesUser = CourseUser::findAll([
            'user_id' => Yii::$app->user->getId(),
        ]);

        $course_id = ArrayHelper::getColumn($coursesUser, 'course_id');
        $courses = [];
        foreach ($course_id as $i => $id) {
            $courses[$i] = ClientHelper::sendRequest('GET', 'course/' . $id . '?expand=lessons0');
            $progress = count($coursesProgress = UserProgressCourse::findAll(['course_id' =>$id ,'user_id' => Yii::$app->user->getId()]))*100;
            $courses[$i]['progress'] = $progress/count($courses[$i]['lessons0']);
        }

        return $this->render('my', ['courses' => $courses, 'courseUser' => $coursesUser]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
            if ($model->load(Yii::$app->request->post()) && $model->signup()) {

                $login = new LoginForm();
                $login->username = $model->username;
                $login->password = $model->password;
                $login->login();
                return $this->redirect(['site/add-personal-info']);
            }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->can('adminAccess')) {
                return $this->redirect(['admin/default/index']);
            } else
                return $this->redirect(['site/my']);


        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        if(! Yii::$app->user->isGuest){
            Yii::$app->user->logout();
            return $this->redirect(['login']);
        }
    }

    public function actionAddPersonalInfo()
    {
        $personalInfo = new PersonalInfo();

        if ($personalInfo->load(Yii::$app->request->post()) && $personalInfo->validate()) {
            $user = User::findOne(Yii::$app->user->getId());
            $user->name = $personalInfo->name;
            $user->last_name = $personalInfo->last_name;
            $user->update();
            return $this->redirect(['site/my']);
        }
        return $this->render('personalInfo', ['personalInfo' => $personalInfo]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для получения дальнейших инструкций.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'К сожалению, мы не можем сбросить пароль для указанного адреса электронной почты.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Ваш email был успешно подтвержден!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'К сожалению, мы не можем подтвердить вашу учетную запись с помощью предоставленного токена.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для получения дальнейших инструкций.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'К сожалению, мы не можем повторно отправить письмо с подтверждением на указанный адрес электронной почты.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

}
