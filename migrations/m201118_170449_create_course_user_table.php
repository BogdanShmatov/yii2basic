<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%course_user}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%order}}`
 */
class m201118_170449_create_course_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%course_user}}', [
            'id' => $this->primaryKey(),
            'course_id' => $this->integer(),
            'user_id' => $this->integer(),
            'order_id' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-course_user-user_id}}',
            '{{%course_user}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-course_user-user_id}}',
            '{{%course_user}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `order_id`
        $this->createIndex(
            '{{%idx-course_user-order_id}}',
            '{{%course_user}}',
            'order_id'
        );

        // add foreign key for table `{{%order}}`
        $this->addForeignKey(
            '{{%fk-course_user-order_id}}',
            '{{%course_user}}',
            'order_id',
            '{{%order}}',
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
            '{{%fk-course_user-user_id}}',
            '{{%course_user}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-course_user-user_id}}',
            '{{%course_user}}'
        );

        // drops foreign key for table `{{%order}}`
        $this->dropForeignKey(
            '{{%fk-course_user-order_id}}',
            '{{%course_user}}'
        );

        // drops index for column `order_id`
        $this->dropIndex(
            '{{%idx-course_user-order_id}}',
            '{{%course_user}}'
        );

        $this->dropTable('{{%course_user}}');
    }
}
