<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balance_enroll".
 *
 * @property int $id
 * @property int|null $sum
 * @property int|null $user_id
 * @property int|null $invoice_id
 * @property int|null $operation_id
 * @property string|null $key
 * @property string|null $status
 * @property string|null $created_at
 *
 * @property User $user
 */
class BalanceEnroll extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'balance_enroll';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sum', 'user_id', 'invoice_id', 'operation_id'], 'integer'],
            [['created_at'], 'safe'],
            [['key', 'status'], 'string', 'max' => 255],
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
            'sum' => 'Sum',
            'user_id' => 'User ID',
            'invoice_id' => 'Invoice ID',
            'operation_id' => 'Operation ID',
            'key' => 'Key',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
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
