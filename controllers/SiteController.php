<?php

namespace app\controllers;

use app\models\ResendVerificationEmailForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use app\models\VerifyEmailForm;
use yii\base\InvalidArgumentException;
use app\models\SignupForm;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use Yii;
use yii\web\Controller;
use app\models\EntryForm;
use yii\httpclient\Client;



class SiteController extends Controller
{
    public $categoriesMenu;

    public function init()
    {
        if (!Yii::$app->user->isGuest) {
            $this->layout = 'my';
        }

        parent::init();
        $this->actionCategories();

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
        return $this->render('index');
    }

    public function actionMy()
    {
        return $this->render('my');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
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
//            return $this->goBack();
            return $this->render('my');

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

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
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
            Yii::$app->session->setFlash('success', 'New password saved.');

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
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
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
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionCourses()
    {
        $client = new Client(['baseUrl' => 'http://appapi',]);
        $coursesResponse = $client->get('course?expand=cat')
            ->setFormat(Client::FORMAT_JSON)
            ->send();
        $courses = json_decode($coursesResponse->content);
        return $this->render('courses',['courses'=>$courses]);

    }

    public function actionCategories()
    {
        $client = new Client(['baseUrl' => 'http://appapi',]);
        $categoriesResponse = $client->get('category')
            ->setFormat(Client::FORMAT_JSON)
            ->send();
        $categories = json_decode($categoriesResponse->content);
        $this->categoriesMenu = $categories;

        return $this->render('category',['categories'=>$categories]);

    }

    public function actionView($id)
    {
        $client = new Client(['baseUrl' => 'http://appapi/course/',]);
        $courseSingleResponse = $client->get($id)
            ->setFormat(Client::FORMAT_JSON)
            ->send();
        $courseSingle = json_decode($courseSingleResponse->content);

        return $this->render('singleCourse',['courseSingle' => $courseSingle]);
    }


        
}
