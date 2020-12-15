<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%course}}`
 * - `{{%user}}`
 */
class m201014_161448_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'content' => $this->string()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),

        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-comment-user_id}}',
            '{{%comment}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-comment-user_id}}',
            '{{%comment}}',
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
        // drops foreign key for table `{{%course}}`
        $this->dropForeignKey(
            '{{%fk-comment-course_id}}',
            '{{%comment}}'
        );

        // drops index for column `course_id`
        $this->dropIndex(
            '{{%idx-comment-course_id}}',
            '{{%comment}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-comment-user_id}}',
            '{{%comment}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-comment-user_id}}',
            '{{%comment}}'
        );

        $this->dropTable('{{%comment}}');
    }
}
