<?php


namespace app\models;

use Yii;
use yii\base\Model;



class PayByCardForm extends Model
{
    public $cardNumber;
    public $expMonth;
    public $expYear;
    public $cvc;
    public $cardName;
    public $saveCard;

    private $_card;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['cardNumber', 'expMonth', 'expYear', 'cvc', 'cardName'], 'required'],

            [['cardNumber', 'expMonth', 'expYear', 'cvc', 'cardName'], 'default'],

            ['cardNumber', 'number', 'message' => 'Не корректный номер карты'],

            [['cardNumber', 'expMonth', 'expYear', 'cvc', 'cardName'], 'validateCard'],

            ['expMonth', 'number', 'min' => 1, 'max' => 12, 'message' => 'Проверьте введенные данных'],

            ['expYear', 'number', 'min' => 20, 'max' => 25, 'message' => 'Проверьте введенные данных'],

            ['cvc', 'number', 'message' => 'Не корректный cvc'],

            ['cardName', 'string', 'max' => 255],

            ['saveCard', 'boolean'],

        ];
    }
    public function validateCard($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $card = $this->getCardInfo();

              if (!$card) {

                  $this->addError($attribute, 'Не правильные данные.');
              }
        }

    }

    public function createNewOrder($courses)
    {
        $order = new Order();
        $order->user_id = Yii::$app->user->getId();
        $order->course_id = $courses['id'];
        $order->order_total_price = $courses['course_price'];
        $order->order_status = "Завершен";

        $courseUser = new CourseUser();
        $courseUser->user_id = Yii::$app->user->getId();
        $courseUser->course_id = $courses['id'];

        $card = Card::findOne(['card_number' => $this->cardNumber]);

        if ($order->order_total_price === 0) {

            $order->save();
            $courseUser->order_id = $order->id;
            $courseUser->save();
        }

        if ($card->card_balance >= $order->order_total_price) {

            $card->card_balance -=  $order->order_total_price;
            $card->update();
            $order->save();
            $courseUser->order_id = $order->id;
            $courseUser->save();

        } else return $this->addError('cardName', 'ОШИБКА ОПЛАТЫ, не достаточно средств!!!');


        if ($this->saveCard) {

            $cardUser = new CardUser();
            $cardUser->user_id = Yii::$app->user->getId();
            $cardUser->card_id = $card->id;
            $cardUser->save();
        }


    }

    protected function getCardInfo()
    {
        if ($this->_card === null) {

            $this->_card = Card::findCard($this->cardNumber, $this->expMonth, $this->expYear, $this->cvc );
        }

        return $this->_card;
    }

}