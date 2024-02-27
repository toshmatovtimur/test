<?php

namespace app\controllers;

use app\db_models\Users;
use app\db_models\UsersSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;


class MyController extends Controller
{ 
    public function behaviors()
    {
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save())
        {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDownload(): Response|\yii\console\Response
    {
        return \Yii::$app->response->sendFile('..\resources\devochka-kraski-karie-glaza-raznye-tsveta-intel.jpg');
    }

    public function actionTest()
    {
         #region Query подход
        // Работает значительно быстрее, в 10 раз
//        $query = (new Query())
//            ->select(['users.*', 'role.role_user as nameRole'])
//            ->from('users')
//            ->innerJoin('role', 'role.id = users.fk_role')
//            ->all();
         #endregion

        $query = Users::find()
            ->select(['users.*', 'role.role_user as nameRole'])
            ->innerJoinWith('role', 'role.id = users.fk_role')
            ->all();

        // Работает медленно, ООП способ
        $query = Users::find()
            ->select(['users.*', 'role.role_user as nameRole'])
            ->innerJoinWith('role', 'role.id = users.fk_role')
            ->all();

        return $this->render('test', ['query' => $query]);



    }

    #endregion

    protected function findModel($id)
    {
        if (($model = Users::findOne(['id' => $id])) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
