<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%balance_enroll}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m210121_150117_create_balance_enroll_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%balance_enroll}}', [
            'id' => $this->primaryKey(),
            'sum' => $this->integer(),
            'user_id' => $this->integer(),
            'invoice_id' => $this->integer(),
            'operation_id' => $this->integer(),
            'key' => $this->string(),
            'status' => $this->string(),
            'created_at' => $this->dateTime(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-balance_enroll-user_id}}',
            '{{%balance_enroll}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-balance_enroll-user_id}}',
            '{{%balance_enroll}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-balance_enroll-user_id}}',
            '{{%balance_enroll}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-balance_enroll-user_id}}',
            '{{%balance_enroll}}'
        );

        $this->dropTable('{{%balance_enroll}}');
    }
}
