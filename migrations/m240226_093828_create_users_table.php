<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m240226_093828_create_users_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),





        ]);
    }




    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
