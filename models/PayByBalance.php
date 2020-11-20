<?php


namespace app\models;


use Yii;
use yii\base\Model;

class PayByBalance extends Model
{
    public $message;

    public function rules()
    {
        return [

            ['message', 'boolean'],
            [['message'], 'default'],

        ];
    }

    public function createOrder($course, $user)
    {


        if ($user->balance >= $course['course_price'] || $course['course_price'] === 0) {

            $order = new Order();
            $order->user_id = $user->id;
            $order->course_id = $course['id'];
            $order->order_total_price = $course['course_price'];
            $user->balance -= $course['course_price'];
            $user->update();
            $order->order_status = "Завершен";
            $order->save();

            $courseUser = new CourseUser();
            $courseUser->user_id = $user->id;;
            $courseUser->course_id = $course['id'];
            $courseUser->order_id = $order->id;
            $courseUser->save();

            return true;
        } else return $this->addError('message', 'ОШИБКА ОПЛАТЫ, не достаточно средств!!!');

    }
}