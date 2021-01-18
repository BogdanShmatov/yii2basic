<?php

namespace app\controllers;

use Yii;

use app\models\Card;
use app\models\CardUser;
use app\models\Comment;
use app\models\PayByCardForm;
use app\models\Post;
use app\models\User;
use app\common\helpers\ClientHelper;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ProfileController extends \yii\web\Controller
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
        $model = new PayByCardForm();
        $user = User::findOne(Yii::$app->user->getId());
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->enrollBalance()) {

            return $this->redirect(['profile/index']);

        }

        return $this->render('balance',['model'=>$model, 'user' => $user]);
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
        if (!is_numeric($id)) {
            throw new BadRequestHttpException();
        }
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
        if (!is_numeric($id)) {
            throw new BadRequestHttpException();
        }
        $comment = Comment::findOne($id);
        if ($comment->user_id == Yii::$app->user->getId()) {
            $comment->delete();
        }

        return $this->redirect(['site/my']);
    }


}
