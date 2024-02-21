<?php

namespace app\db_models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $lastname
 * @property string|null $brithday
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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brithday', 'date_last_logout'], 'safe'],
            [['sex'], 'string'],
            [['fk_role'], 'default', 'value' => null],
            [['fk_role'], 'integer'],
            [['firstname', 'middlename', 'lastname', 'password'], 'string', 'max' => 120],
            [['email'], 'string', 'max' => 60],
            [['nickname'], 'string', 'max' => 100],
            [['fk_role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['fk_role' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'lastname' => 'Lastname',
            'brithday' => 'Brithday',
            'sex' => 'Sex',
            'email' => 'Email',
            'password' => 'Password',
            'date_last_logout' => 'Date Last Logout',
            'nickname' => 'Nickname',
            'fk_role' => 'Fk Role',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['fk_user' => 'id']);
    }

    /**
     * Gets query for [[FkRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkRole()
    {
        return $this->hasOne(Role::class, ['id' => 'fk_role']);
    }

    /**
     * Gets query for [[Views]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViews()
    {
        return $this->hasMany(View::class, ['fk_user' => 'id']);
    }
}
