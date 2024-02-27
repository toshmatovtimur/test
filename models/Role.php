<?php

namespace app\models;


use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%role}}".
 *
 * @property int $id
 * @property string|null $role_user
 *
 * @property Content[] $contents
 * @property User[] $users
 */
class Role extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%role}}';
    }


    public function rules()
    {
        return [
            [['role_user'], 'string', 'max' => 50],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'role_user' => 'Роль',
        ];
    }

    /**
     * Gets query for [[Contents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(Contents::class, ['fk_status' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['fk_role' => 'id']);
    }
}
