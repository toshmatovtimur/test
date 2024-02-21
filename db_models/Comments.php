<?php

namespace app\db_models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%comments}}".
 *
 * @property int $id
 * @property int|null $fk_content
 * @property int|null $fk_user
 * @property string|null $date_write_comment
 * @property string|null $comment
 *
 * @property Content $fkContent
 * @property User $fkUser
 */
class Comments extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%comments}}';
    }

    public function rules()
    {
        return [
            [['fk_content', 'fk_user'], 'default', 'value' => null],
            [['fk_content', 'fk_user'], 'integer'],
            [['date_write_comment'], 'safe'],
            [['comment'], 'string'],
            [['fk_content'], 'exist', 'skipOnError' => true, 'targetClass' => Content::class, 'targetAttribute' => ['fk_content' => 'id']],
            [['fk_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['fk_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_content' => 'Fk Content',
            'fk_user' => 'Fk User',
            'date_write_comment' => 'Date Write Comment',
            'comment' => 'Comment',
        ];
    }

    /**
     * Gets query for [[FkContent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkContent()
    {
        return $this->hasOne(Content::class, ['id' => 'fk_content']);
    }

    /**
     * Gets query for [[FkUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkUser()
    {
        return $this->hasOne(User::class, ['id' => 'fk_user']);
    }
}
