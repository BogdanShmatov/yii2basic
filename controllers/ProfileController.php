<?php

namespace app\controllers;

use Yii;

use app\models\Card;
use app\models\CardUser;
use app\models\Comment;
use app\models\PayByCardForm;
use app\models\Post;
use app\models\User;
use app\helpers\ClientHelper;

class ProfileController extends \yii\web\Controller
{
    public function init()
    {
        parent::init();
        $this->view->params['categories'] = ClientHelper::sendRequest('GET', 'category');

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

    public function actionDeleteCard($id)
    {
        $userCard = CardUser::findOne($id);
        $userCard->delete();

        return $this->redirect(['profile/view-my-cards']);
    }

    public function actionDeleteComment($id)
    {
        $comment = Comment::findOne($id);
        $comment->delete();

        return $this->redirect(['profile/view-my-comments']);
    }


}
