<?php

namespace app\models;

use yii\base\Model;

class AuthForm extends Model
{
	public $email;
	public $password_md5;
	public $verifyCode;


	public function rules()
	{
		return
		[
			[['password', 'email'], 'required' ],
			[ 'email', 'email' ],
			[ 'verifyCode', 'captcha' ],
		];
	}

	public function attributeLabels()
	{
		return
		[
			'email' => 'Email',
			'password_md5' => 'Пароль',
			'verifyCode' => 'Введите слово ',
		];
	}

	



}


