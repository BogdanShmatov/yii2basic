<?php


namespace app\models;


class PersonalInfo extends \yii\base\Model
{
    public $name;
    public $last_name;

    public function rules()
    {
        return [
            [['name', 'last_name'], 'string', 'max' => '255'],
            [['name', 'last_name'], 'required'],
        ];
    }
}