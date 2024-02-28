<?php

namespace app\models;

use yii\base\Model;

class AuthForm extends Model
{


	public $email;
	public $password;

	public function rules()
	{
		return [
			[['password', 'email'], 'required' ],
			[ 'email', 'email' ],
		];
	}

}


