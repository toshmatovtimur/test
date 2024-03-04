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

		public $password;

		public $confirm;

		public $verifyCode;


		public function rules()  // Правила
		{
			return
			[
				[['password', 'email', 'firstname', 'middlename', 'birthday', 'sex', 'email', 'password', 'confirm'], 'required' ],
				[['password', 'email', 'firstname', 'middlename', 'birthday', 'sex', 'email', 'password', 'confirm'], 'trim' ],
				[ 'email', 'email'],
				[ 'email', 'unique', 'targetClass' => '\app\models\Users', 'message' => 'This email address has already been taken.' ],
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
				'password' => 'Пароль',
				'confirm' => 'Повторите пароль',
				'verifyCode' => 'Напечатайте слово',
			];
		}
	}