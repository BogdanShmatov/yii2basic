<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_progress_course}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m201226_072543_create_user_progress_course_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_progress_course}}', [
            'id' => $this->primaryKey(),
            'course_id' => $this->integer(),
            'lesson_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_progress_course-user_id}}',
            '{{%user_progress_course}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_progress_course-user_id}}',
            '{{%user_progress_course}}',
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
            '{{%fk-user_progress_course-user_id}}',
            '{{%user_progress_course}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_progress_course-user_id}}',
            '{{%user_progress_course}}'
        );

        $this->dropTable('{{%user_progress_course}}');
    }
}
