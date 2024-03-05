<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m240304_035219_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
	        'firstname' => $this->string(120),
	        'middlename'=> $this->string(120),
	        'lastname'=> $this->string(120),
	        'birthday'=> $this->date(),
	        'auth_key'=> $this->string(120),
	        'sex'=> $this->string(20),
	        'email'=> $this->string(70),
	        'password_md5'=> $this->string(120),
	        'date_last_logout'=> $this->timestamp(),
	        'fk_role'=> $this->integer(),
	        'created_at'=> $this->timestamp(),
	        'updated_at'=> $this->timestamp(),
	        'status'=> $this->integer(),
	        'password_reset_token'=> $this->string(120),
        ]);

	    // add foreign key for table `role`
	    $this->addForeignKey(
		    'users_fk_role_fkey',
		    'users',
		    'fk_role',
		    'role',
		    'id',
		    'NO ACTION'
	    );



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');

	    // drops foreign key for table `category`
	    $this->dropForeignKey(
		    'users_fk_role_fkey',
		    'users'
	    );
    }
}
