<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 */
class m230402_183328_create_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'sectionId' => $this->integer()->notNull(),
            'header' => $this->string(256)->notNull(),
            'body' => $this->string(1000)->notNull(),
            'media' => $this->string(256),
            'created_at' => $this->timestamp(),
        ]);

        $this->addForeignKey('fk_user_post', 'posts', 'userId', 'users', 'id');
        $this->addForeignKey('fk_section_post', 'posts', 'sectionId', 'sections', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posts}}');
    }
}
