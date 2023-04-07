<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m230402_204042_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string(1000)->notNull(),
            'userId' => $this->integer()->notNull(),
            'postId' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk_user_comment', 'comments', 'userId', 'users', 'id');
        $this->addForeignKey('fk_post_comment', 'comments', 'postId', 'posts', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comments}}');
    }
}
