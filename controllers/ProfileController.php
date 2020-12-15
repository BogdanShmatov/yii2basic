<?php

namespace app\controllers;

use app\models\Card;
use app\models\CardUser;
use app\models\Comment;
use app\models\PayByCardForm;
use Yii;
use app\models\User;
use yii\web\Session;

class ProfileController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
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

                return $this->redirect(['course/get-courses']);
            }
        }
        return $this->render('profile', ['model' => $model]);

    }

    public function actionViewBalance()
    {
        $model = new PayByCardForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->enrollBalance()) {

            Yii::$app->session->setFlash('success', 'Баланс пополнен!!');

            return $this->redirect(['course/get-courses']);

        }

        return $this->render('balance',['model'=>$model]);
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
