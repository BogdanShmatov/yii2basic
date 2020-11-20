<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%card_user}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%card}}`
 * - `{{%user}}`
 */
class m201118_171000_create_card_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%card_user}}', [
            'id' => $this->primaryKey(),
            'card_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);

        // creates index for column `card_id`
        $this->createIndex(
            '{{%idx-card_user-card_id}}',
            '{{%card_user}}',
            'card_id'
        );

        // add foreign key for table `{{%card}}`
        $this->addForeignKey(
            '{{%fk-card_user-card_id}}',
            '{{%card_user}}',
            'card_id',
            '{{%card}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-card_user-user_id}}',
            '{{%card_user}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-card_user-user_id}}',
            '{{%card_user}}',
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
        // drops foreign key for table `{{%card}}`
        $this->dropForeignKey(
            '{{%fk-card_user-card_id}}',
            '{{%card_user}}'
        );

        // drops index for column `card_id`
        $this->dropIndex(
            '{{%idx-card_user-card_id}}',
            '{{%card_user}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-card_user-user_id}}',
            '{{%card_user}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-card_user-user_id}}',
            '{{%card_user}}'
        );

        $this->dropTable('{{%card_user}}');
    }
}
