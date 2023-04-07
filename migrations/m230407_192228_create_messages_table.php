<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%messages}}`.
 */
class m230407_192228_create_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%messages}}', [
            'id' => $this->primaryKey(),
            'user_one' => $this->integer()->notNull(),
            'user_two' => $this->integer()->notNull(),
            'body' => $this->string(1000)->notNull(),
        ]);

        $this->addForeignKey('fk_user_messages_one', 'messages', 'user_one', 'users', 'id');
        $this->addForeignKey('fk_user_messages_two', 'messages', 'user_two', 'users', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%messages}}');
    }
}
