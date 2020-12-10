<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $cat_name
**/
class Category extends Model
{
    public $cat_name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_name'], 'required'],
            [['cat_name'], 'string', 'max' => 255],
        ];
    }

}
