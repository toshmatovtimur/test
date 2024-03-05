<?php

namespace app\controllers;

use app\models\Users;
use app\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;


class MyController extends Controller
{

    public function behaviors()
    {
        $min = 5;
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    #region Actions

    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }


    public function actionCreate()
    {
        $model = new Users();

        if ($this->request->isPost)
        {
            if ($model->load($this->request->post()) && $model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else
        {
            $model->loadDefaultValues();
        }

        return $this->render('create', ['model' => $model]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost
            && $model->load($this->request->post())
            && $model->save())
        {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }


    public function actionDelete($id)
    {
        $this->FindModel($id)->delete();

        

        return $this->redirect(['index']);
    }


    public function actionDownload() // Скачивание
    {
        return Yii::$app->response->sendFile('..\resources\devochka-kraski-karie-glaza-raznye-tsveta-intel.jpg');
    }


    public function actionTest()
    {

//		$model = Users::find()
//			->select(['users.*', 'role.role_user as nameRole'])
//			->innerJoinWith('role', 'role.id = users.fk_role')
//			->where(['users.id' => 1])
//			->one();

	        $hash_admin = md5('admin');
	        $hash_user = md5('user');
			return $this->render('test', compact('hash_admin', 'hash_user'));

    }
    #endregion



    protected function FindModel($id) // Метод для запроса
    {
		$model = Users::find()
			->select(['users.*', 'role.role_user as nameRole'])
			->innerJoinWith('role', 'role.id = users.fk_role')
			->where(['users.id' => $id])
			->one();


        if ($model !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');

    }

}
