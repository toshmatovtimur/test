<?php

namespace app\db_models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
 * @property string|null $password
 * @property string|null $date_last_logout
 * @property string|null $nickname
 * @property int|null $fk_role
 *
 * @property Comment[] $comments
 * @property Role $fkRole
 * @property View[] $views
 */
class Users extends ActiveRecord
{

    public $nameRole;

    // Имя таблицы по умолчанию
    public static function tableName()
    {
        return 'users';
    }

    // Правила валидации (проверки)
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

    // Атрибуты
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
            'fk_role' => 'Роль',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['fk_user' => 'id']);
    }

    /**
     * Gets query for [[FkRole]].
     *
     * @return ActiveQuery
     */
    public function getRole(): ActiveQuery
    {
        return $this->hasOne(Role::class, ['id' => 'fk_role']);
    }

    /**
     * Gets query for [[Views]].
     *
     * @return ActiveQuery
     */
    public function getViews(): ActiveQuery
    {
        return $this->hasMany(Views::class, ['fk_user' => 'id']);
    }

}
