<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\AuthForm;
use app\models\SignupForm;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;


class SiteController extends Controller
{
    public function behaviors() // Правила
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'login', 'signup'],
                'rules' => [
	                [
		                'allow' => true,
		                'actions' => ['login', 'signup'],
		                'roles' => ['?'],
	                ],

	                [
		                'allow' => true,
		                'actions' => ['logout'],
		                'roles' => ['@'],
	                ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => ['logout' => ['post'],],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }



    public function actionLogin() // Авторизация // Дополнить
    {
		$model = new AuthForm();

		if($model->load(Yii::$app->request->post()))
		{
			$email = Yii::$app->request->post("AuthForm")["email"];
			$pass = Yii::$app->request->post("AuthForm")["password_md5"];
			$captcha = Yii::$app->request->post("AuthForm")["verifyCode"];

			$query = Users::find()->where(['email' => $email, 'password_md5' => md5($pass)])->one();

			if(!empty($query) && $captcha)
			{
				return $this->goHome();
			}

			return $this->render('login', compact('model'));

		}

		return $this->render('login', compact('model'));
    }
	public function actionLogout() // Выход
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}
	public function actionSignup() // Регистрация
	{

		$model = new SignupForm();
		$arr = null;

		if($model->load(Yii::$app->request->post()))
		{


			$arr = Yii::$app->request->post();

				$user = new Users();
				$user->firstname = Yii::$app->request->post("SignupForm")["firstname"];
				$user->middlename = Yii::$app->request->post("SignupForm")["middlename"];
				$user->lastname  = Yii::$app->request->post("SignupForm")["lastname"];
				$user->birthday   = Yii::$app->request->post("SignupForm")["birthday"];
				$user->sex       = Yii::$app->request->post("SignupForm")["sex"];
				$user->email     = Yii::$app->request->post("SignupForm")["email"];
				$passMd5 = Yii::$app->request->post('SignupForm')["password_md5"];
				$user->password_md5  = md5($passMd5);
			    $user->created_at = date("Y-m-d");
				$user->fk_role    = 1;

				$user->save();



			return $this->render('signup', compact('model', 'arr'));

		}



		//		if($model->load(Yii::$app->request->post()))
//		{
//			$email = Yii::$app->request->post("SignupForm")["email"];
//			$pass = Yii::$app->request->post("SignupForm")["password_md5"];
//			$captcha = Yii::$app->request->post("SignupForm")["verifyCode"];
//
//			$query = Users::find()->where(['email' => $email, 'password_md5' => md5($pass)])->one();
//
//			if(!empty($query) && $captcha)
//			{
//				Yii::$app->user->login();
//				return $this->goHome();
//			}
//
//			return $this->render('signup', compact('model'));
//
//		}

		return $this->render('signup', compact('model', 'arr'));

	}




	#region Неиспользуемые пока функции
	public function actionContact() // Displays contact page.
	{
//        $model = new ContactForm();
//        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail']))
//        {
//            Yii::$app->session->setFlash('contactFormSubmitted');
//
//            return $this->refresh();
//        }
//
//        return $this->render('contact', compact('model'));

	}
	public function actionAbout() // Displays about page.
	{
		return $this->render('about');
	}
	#endregion
}
