<?php


namespace app\models;


class Lesson extends \yii\base\Model
{
    public $lesson_name;
    public $lesson_url;
    public $course_id;

    public function rules(){
        return [
            [['lesson_name', 'lesson_url'], 'required'],
            [['lesson_name', 'lesson_url'], 'string'],
            ['course_id', 'integer'],

        ];
    }
}