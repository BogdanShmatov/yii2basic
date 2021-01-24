<?php

namespace app\controllers;

use Yii;

use app\models\Card;
use app\models\CardUser;
use app\models\Comment;
use app\models\PayByCardForm;
use app\models\Post;
use app\models\User;
use app\models\BalanceEnroll;
use app\common\helpers\ClientHelper;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
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
    public function actionIndex()
    {
        $model = Post::findAll(['user_id' => Yii::$app->user->getId()]);
        $user = User::findOne(Yii::$app->user->getId());
        return $this->render('index', ['model' => $model, 'user' => $user]);
    }

    public function actionEditProfile()
    {
        $model = User::findOne(Yii::$app->user->getId());
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $data = Yii::$app->request->post();
            $model->name = $data['User']['name'];
            $model->last_name =  $data['User']['last_name'];

            if ($model->save()) {

                Yii::$app->session->setFlash('success', 'Данные сохранены!! Теперь ты - '.$model->name.' '.$model->last_name);

                return $this->redirect(['profile/index']);
            }
        }
        return $this->render('profile', ['model' => $model]);

    }

    public function actionViewBalance()
    {
        $cookies = Yii::$app->request->cookies;
        if (($cookie = $cookies->get('balance')) !== null) {
            $values = $cookie->value;
            $invoice_id = $values['invoice_id'];
            $key = $values['key'];
            $sum = $values['sum'];
            $operation_id = $values['operation_id'];
            $tpmBalanceEnroll = BalanceEnroll::findOne([
                'user_id' => Yii::$app->user->getId(),
                'sum' => $sum,
                'invoice_id' => $invoice_id,
                'key' => $key,
                'operation_id' => $operation_id
            ]);
            if ($status = ClientHelper::checkInvoiceStatus($invoice_id, $key) && !$tpmBalanceEnroll) {

                $model = new PayByCardForm();
                if ($model->enrollBalance($sum, $values)) {
                    $cookies = Yii::$app->response->cookies;
                    $cookies->removeAll();
                    unset($values, $invoice_id, $key, $course_id, $cookie);
                }
            }
        }
        $model = new PayByCardForm();
        $user = User::findOne(Yii::$app->user->getId());

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            return $this->redirect(['profile/enroll-balance', 'sum'=>$model->sum]);

        }

        return $this->render('balance',['model'=>$model, 'user' => $user->balance]);
    }

    public function actionEnrollBalance(int $sum)
    {

        $token = ClientHelper::authWooppay('test_merch','A12345678a');
        $data = [
            "service_name" => "test_merch_invoice",
            "reference_id" => time(),
            "amount" => $sum,
            "merchant_name" => "test_merch",
            "request_url"=> "https://www.test.wooppay.com",
            "back_url"=> "http://academic/profile/view-balance/",
        ];
        $invoice  = ClientHelper::createInvoice('/invoice/create', $data, $token);
        $values = [
            'invoice_id' => $invoice['response']['invoice_id'],
            'key' => $invoice['response']['key'],
            'operation_id' => $invoice['response']['operation_id'],
            'sum' => $sum
        ];
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'balance',
            'value' => $values,
        ]));
        $frame_url = $invoice['operation_url'];
        $user = User::findOne(Yii::$app->user->getId());


        return $this->render('enrollBalance', [
            'frame_url' => $frame_url,
            'user' => $user->balance,
            'sum' => $sum
            ]);
    }

    public function actionViewMyCards()
    {
        $cardUserId = CardUser::findAll(['user_id' => Yii::$app->user->getId()]);
        $cards = [];

            foreach ($cardUserId as $i => $card) {

                $tmpCards = Card::findOne(($card['card_id']));
                $cards[$i] = array("id" => $card['id'],"card_number" => substr($tmpCards->card_number,12, 4 ));

            }

        return $this->render('cards',['model'=>$cards]);
    }

    public function actionDeleteCard(int $id)
    {
        $cardUserId = CardUser::findAll(['user_id' => Yii::$app->user->getId()]);
        $cards = ArrayHelper::getColumn($cardUserId,'id');
        if (!in_array($id, $cards)) {
            throw new NotFoundHttpException('Такая карта не добавленна');
        }
        $userCard = CardUser::findOne($id);
        $userCard->delete();

        return $this->redirect(['profile/view-my-cards']);
    }

    public function actionDeleteComment(int $id)
    {
        $comment = Comment::findOne($id);
        if ($comment->user_id == Yii::$app->user->getId()) {
            $comment->delete();
        }

        return $this->redirect(['site/my']);
    }


}
