<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%card}}".
 *
 * @property int $id
 * @property string|null $card_number
 * @property int|null $card_month
 * @property int|null $card_year
 * @property int|null $card_cvc
 * @property int|null $card_balance
 * @property string|null $card_Name
 */
class Card extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%card}}';
    }

    public function behaviors()
    {
        return [
            //Использование поведения TimestampBehavior ActiveRecord
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],

                ],
                //можно использовать 'value' => new \yii\db\Expression('NOW()'),
                'value' => function(){
                    return gmdate("Y-m-d H:i:s");
                },


            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_month', 'card_year', 'card_cvc', 'card_balance'], 'integer'],
            [['card_number', 'card_Name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_number' => 'Card Number',
            'card_month' => 'Card Month',
            'card_year' => 'Card Year',
            'card_cvc' => 'Card Cvc',
            'card_balance' => 'Card Balance',
            'card_Name' => 'Card Name',
        ];
    }

    public static function findCard($cardNumber, $mm, $yy, $cvc)
    {
        return static::findOne(['card_number' => $cardNumber,
                                'card_month' => $mm,
                                'card_year' => $yy,
                                'card_cvc' => $cvc,
                                ]);
    }

    public static function findCardByNumber($cardNumber)
    {
        return static::findOne(['card_number' => $cardNumber]);
    }

    public function validateCard($cardNumber, $mm, $yy, $cvc)
    {
        if ($cardNumber === $this->card_number && $mm === $this->card_month &&
            $yy === $this->card_year && $cvc === $this->card_cvc) {

                return true;

            } else return false;

    }
}
