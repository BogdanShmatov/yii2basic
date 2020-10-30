<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "course".
 *
 * @property int $id
 * @property int|null $cat_id
 * @property string $course_name
 * @property string $course_author
 * @property string $course_img_url
 * @property string $course_video_url
 * @property string $course_description
 * @property int $course_price
 * @property string $course_preview
 * @property int $course_isFree
 *
 * @property Comment[] $comments
 * @property Category $cat
 * @property CourseUser[] $courseUsers
 * @property User[] $users
 * @property Order[] $orders
 */
class Course extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course';
    }

    public function fields()
    {
        return ['id', 'course_name', 'course_author', 'course_description', 'course_price', 'course_isFree'];
    }

    public function extraFields()
    {
        return ['cat'];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_id', 'course_price', 'course_isFree'], 'integer'],
            [['course_name', 'course_author', 'course_img_url', 'course_video_url', 'course_description', 'course_price', 'course_preview'], 'required'],
            [['course_name', 'course_author', 'course_img_url', 'course_video_url', 'course_description', 'course_preview'], 'string', 'max' => 255],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['cat_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'course_name' => 'Course Name',
            'course_author' => 'Course Author',
            'course_img_url' => 'Course Img Url',
            'course_video_url' => 'Course Video Url',
            'course_description' => 'Course Description',
            'course_price' => 'Course Price',
            'course_preview' => 'Course Preview',
            'course_isFree' => 'Course Is Free',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Cat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Category::className(), ['id' => 'cat_id']);
    }

    /**
     * Gets query for [[CourseUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseUsers()
    {
        return $this->hasMany(CourseUser::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('course_user', ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['course_id' => 'id']);
    }
}
