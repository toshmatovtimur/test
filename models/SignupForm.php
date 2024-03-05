<?php

	namespace app\models;

	use yii\base\Model;

	class SignupForm extends Model
	{
		public $firstname;

		public $middlename;

		public $lastname;

		public $birthday;

		public $sex;

		public $email;

		public $password_md5;

		public $confirm;

		public $verifyCode;

		public function rules()  // Правила
		{
			return
			[
				[['password_md5', 'email', 'firstname', 'middlename', 'birthday', 'sex', 'email', 'confirm'], 'required' ],
				[['password_md5', 'email', 'firstname', 'middlename', 'birthday', 'sex', 'email', 'confirm'], 'trim' ],
				['password_md5', 'string', 'min' => 6],
				['confirm', 'compare', 'compareAttribute'=>'password_md5', 'message'=>"Пароли не совпадают" ],
				[ 'email', 'email'],
				[ 'email', 'unique'],
				[ 'verifyCode', 'captcha' ],
			];
		}


		public function attributeLabels() // Аттрибуты
		{
			return
			[
				'firstname' => 'Фамилия',
				'middlename' => 'Имя',
				'lastname' => 'Отчество',
				'birthday' => 'Дата рождения',
				'sex' => 'Пол',
				'email' => 'Email',
				'password_md5' => 'Пароль',
				'confirm' => 'Повторите пароль',
				'verifyCode' => 'Напечатайте слово',
			];
		}

	}