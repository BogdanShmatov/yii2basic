<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "slider_image".
 *
 * @property int $id
 * @property string $img_url
 */
class SliderImage extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['img_url'], 'string', 'max' => 512],
            [['file'], 'image'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'img_url' => 'Img Url',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $dir = 'uploads/';
            $name = 'slider_'. $this->randomFileName($this->file->extension);
            $file = $dir . $name;
            $this->img_url = $file;
            $this->save();
            $this->file->saveAs($file);

            return true;

        } else return false;


    }

    private function randomFileName($extension = false)
    {
        $extension = $extension ? '.' . $extension : '';
        do {
            $name = md5(microtime() . rand(0, 1000));
            $file = $name . $extension;
        } while (file_exists($file));
        return $file;
    }
}
