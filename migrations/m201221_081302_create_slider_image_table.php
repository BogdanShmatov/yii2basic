<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%slider_image}}`.
 */
class m201221_081302_create_slider_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%slider_image}}', [
            'id' => $this->primaryKey(),
            'img_url' => $this->string(512)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%slider_image}}');
    }
}
