<?php


namespace app\models;

use yii\base\Model;


class Card extends Model
{
    public $cardNumber;
    public $expMonth;
    public $expYear;
    public $cvc;
    public $cardName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['cardNumber', 'expMonth', 'expYear', 'cvc', 'cardName'], 'required'],
            [['cardNumber', 'expMonth', 'expYear', 'cvc', 'cardName'], 'default', 'value' => 0],

            ['cardNumber', 'number'],

            ['expMonth', 'number', 'min' => 1, 'max' => 12],

            ['expYear', 'number', 'min' => 20, 'max' => 25],

            ['cvc', 'number'],

            ['cardName', 'string', 'min' => 3, 'max' => 255],

        ];
    }
}