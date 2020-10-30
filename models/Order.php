<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $course_id
 * @property int|null $user_id
 * @property string $order_type_pay
 * @property string $order_created_at
 * @property string $order_updated_at
 * @property int $order_total_price
 * @property string $order_status
 *
 * @property Course $course
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id', 'user_id', 'order_total_price'], 'integer'],
            [['order_type_pay', 'order_created_at', 'order_updated_at', 'order_total_price', 'order_status'], 'required'],
            [['order_created_at', 'order_updated_at'], 'safe'],
            [['order_type_pay', 'order_status'], 'string', 'max' => 255],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course ID',
            'user_id' => 'User ID',
            'order_type_pay' => 'Order Type Pay',
            'order_created_at' => 'Order Created At',
            'order_updated_at' => 'Order Updated At',
            'order_total_price' => 'Order Total Price',
            'order_status' => 'Order Status',
        ];
    }

    /**
     * Gets query for [[Course]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
