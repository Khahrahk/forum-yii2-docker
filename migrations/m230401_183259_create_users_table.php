<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m230401_183259_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(256)->notNull(),
            'password' => $this->string(256),
            'avatar' => $this->integer(2)->defaultValue('default.png'),
            'isAdmin' => $this->integer(2)->defaultValue(0),
            'email' => $this->string(1000)->notNull(),
            'number' => $this->string(256),
            'authKey' => $this->string(256)->null(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
