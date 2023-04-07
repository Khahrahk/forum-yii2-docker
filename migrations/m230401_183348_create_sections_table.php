<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sections}}`.
 */
class m230401_183348_create_sections_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sections}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(256)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sections}}');
    }
}
