<?php

use app\models\Users;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\UsersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Users', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'firstname',
            'middlename',
            'lastname',
            //'birthday',
            //'sex',
            'email:email',
            //'password_md5',
            'date_last_login',
            'fk_role',
            //'created_at',
            //'updated_at',
            //'status',
            //'access_token',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Users $model, $key, $index, $column)
                                {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
