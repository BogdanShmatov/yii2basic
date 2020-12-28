<?php

namespace app\models;

use yii\base\Model;

class Course extends Model
{

    public $course_name;
    public $course_author;
    public $course_img_url;
    public $course_video_url;
    public $course_description;
    public $course_price;
    public $course_preview;
    public $course_isFree;
    public $id;
    public $cat_id;
    public $user_id;

    public function rules()
    {
        return [
            [['cat_id', 'course_price', 'user_id'], 'integer'],
            ['id', 'integer'],
            ['course_isFree', 'boolean'],
            [['course_name', 'course_author', 'course_img_url', 'course_video_url', 'course_description', 'course_price', 'course_preview'], 'required'],
            [['course_name', 'course_author', 'course_img_url', 'course_video_url', 'course_description', 'course_preview'], 'string', 'max' => 255],
        ];
    }

}
