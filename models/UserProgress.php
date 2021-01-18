<?php


namespace app\models;

use Yii;
use yii\base\Model;

class UserProgress extends Model
{
    public $course_id;
    public $lesson_id;
    public $user_id;

    public function rules()
    {
        return [
            [['course_id', 'lesson_id', 'user_id'], 'integer'],
            [['course_id', 'lesson_id'], 'required'],

        ];
    }

    public function saveProgress()
    {
            $userProgress = new UserProgressCourse();
            $userProgress->course_id = $this->course_id;
            $userProgress->lesson_id = $this->lesson_id;
            $userProgress->user_id = Yii::$app->user->getId();
            $userProgress->save();

    }
}