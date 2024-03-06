<?php

	namespace app\controllers;

	use yii\web\Controller;

	class AdminController extends Controller
	{

		public function actionIndex()
		{
			return $this->render('index');
		}

		public function actionUsers()
		{
			return $this->render('show');
		}
	}