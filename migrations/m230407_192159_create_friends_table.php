<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%friends}}`.
 */
class m230407_192159_create_friends_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%friends}}', [
            'id' => $this->primaryKey(),
            'friend_one' => $this->integer()->notNull(),
            'friend_two' => $this->integer()->notNull(),
            'verification_one' => $this->boolean()->defaultValue(0),
            'verification_two' => $this->boolean()->defaultValue(0),
        ]);

        $this->addForeignKey('fk_user_friends_one', 'friends', 'friend_one', 'users', 'id');
        $this->addForeignKey('fk_user_friends_two', 'friends', 'friend_two', 'users', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%friends}}');
    }
}
