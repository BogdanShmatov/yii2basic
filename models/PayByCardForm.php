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
    public $sum;

    private $_card;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['sum', 'integer'],
        ];
    }

    public function createNewOrder($courses, $values)
    {
            $order = new Order();
            $order->user_id = Yii::$app->user->getId();
            $order->course_id = $courses['id'];
            $order->order_total_price = $courses['course_price'];
            $order->order_status = "Завершен";
            $order->key = $values['key'];
            $order->operation_id = $values['operation_id'];
            $order->invoice_id = $values['invoice_id'];;
            $order->save();

            $courseUser = new CourseUser();
            $courseUser->user_id = Yii::$app->user->getId();
            $courseUser->course_id = $courses['id'];
            $courseUser->order_id = $order->id;

            if ($courseUser->save()) {
                return true;
            }

    }

    public function enrollBalance(int $sum, $data)
    {
        $enrollBalance = new BalanceEnroll();

        $enrollBalance->sum = $sum;
        $enrollBalance->invoice_id = $data['invoice_id'];
        $enrollBalance->operation_id = $data['operation_id'];
        $enrollBalance->key = $data['key'];
        $enrollBalance->status = 'Завершен';
        $enrollBalance->created_at = gmdate("Y-m-d H:i:s");
        $enrollBalance->user_id = Yii::$app->user->getId();
        $enrollBalance->save();

        $user = User::findOne(Yii::$app->user->getId());
        $user->balance += $sum;

        if ( $user->update()) {
            return true;
        }

    }

}