<?php

namespace app\models;


use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $lastname
 * @property string|null $birthday
 * @property string|null $auth_key
 * @property string|null $sex
 * @property string|null $email
 * @property string|null $password_md5
 * @property string|null $date_last_logout
 * @property int|null $fk_role
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $status
 * @property string|null $access_token
 *
 * @property Comment[] $comments
 * @property Role $fkRole
 * @property View[] $views
 */
class Users extends ActiveRecord implements IdentityInterface
{
    public $nameRole; // Для отображения Роли при многотабличном запросе
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return "{{%users}}";
    }

    public function rules()
    {
        return [
            [['birthday', 'date_last_logout'], 'date'],
            [['sex'], 'string'],
            [['fk_role'], 'default', 'value' => null],
            [['fk_role'], 'integer'],
            [['firstname', 'middlename', 'lastname', 'password'], 'string', 'max' => 120],
            [['email'], 'string', 'max' => 60],
            [['email'], 'unique'],
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
            'password_md5' => 'Пароль',
            'date_last_logout' => 'Дата последнего входа',
            'nameRole' => 'Роль',
        ];
    }


	public function init()
	{
		parent::init();
		Yii::$app->user->enableSession = false;
	}


	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
			'class' => CompositeAuth::className(),
			'authMethods' => [
				HttpBasicAuth::className(),
				HttpBearerAuth::className(),
				QueryParamAuth::className(),
			],
		];
		return $behaviors;
	}

	public static function findIdentity($id)
	{
		return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['access_token' => $token]);
	}

	public function getId()
	{
		return $this->getPrimaryKey();
	}

	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	public function setPasswordInMD5($password)
	{
		$this->password_hash = md5($password);
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
	}


	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}


	public function getAuthKey()
	{
		return $this->auth_key;
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
