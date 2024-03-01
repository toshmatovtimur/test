<?php

namespace app\models;

use Cassandra\Date;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $lastname
 * @property string|null $birthday
 * @property string|null $sex
 * @property string|null $email
 * @property string|null $password_md5
 * @property string|null $date_last_logout
 * @property string|null $nickname
 * @property int|null $fk_role
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $status
 * @property int|null $password_reset_token
 *
 * @property Comment[] $comments
 * @property Role $fkRole
 * @property View[] $views
 */
class Users extends ActiveRecord
{
    public $nameRole; // Для отображения Роли при многотабличном запросе


    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['birthday', 'date_last_logout'], 'safe'],
            [['birthday', 'date_last_logout'], 'date'],
            [['sex'], 'string'],
            [['fk_role'], 'default', 'value' => null],
            [['fk_role'], 'integer'],
            [['firstname', 'middlename', 'lastname', 'password'], 'string', 'max' => 120],
            [['email'], 'string', 'max' => 60],
            [['email'], 'unique'],
            [['nickname'], 'string', 'max' => 100],
            [['nickname'], 'unique'],
            [['fk_role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['fk_role' => 'id']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'firstname' => 'Фамилия',
            'middlename' => 'Имя',
            'lastname' => 'Отчество',
            'birthday' => 'Дата рождения',
            'sex' => 'Пол',
            'email' => 'Email',
            'password' => 'Пароль',
            'date_last_logout' => 'Дата последнего входа',
            'nickname' => 'Никнейм',
            'nameRole' => 'Роль',
        ];
    }



    

    #region Внешние ключи для многотабличных запросов

    public function getComments()
    {
        return $this->hasMany(Comments::class, ['fk_user' => 'id']);
    }

    public function getRole(): ActiveQuery
    {
        return $this->hasOne(Role::class, ['id' => 'fk_role']);
    }

    public function getViews(): ActiveQuery
    {
        return $this->hasMany(Views::class, ['fk_user' => 'id']);
    }

    #endregion

}
