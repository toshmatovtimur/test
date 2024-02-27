<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%contents}}".
 *
 * @property int $id
 * @property string|null $header
 * @property string|null $alias
 * @property string|null $date_create
 * @property string|null $date_publication
 * @property string|null $text_short
 * @property string|null $text_full
 * @property string|null $date_update_content
 * @property string|null $tags
 * @property int|null $fk_status
 * @property int|null $fk_user_create
 *
 * @property Comment[] $comments
 * @property Contentandfoto[] $contentandfotos
 * @property Role $fkStatus
 * @property Status $fkUserCreate
 * @property View[] $views
 */
class Contents extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contents}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_create', 'date_publication', 'date_update_content'], 'safe'],
            [['text_full'], 'string'],
            [['fk_status', 'fk_user_create'], 'default', 'value' => null],
            [['fk_status', 'fk_user_create'], 'integer'],
            [['header'], 'string', 'max' => 100],
            [['alias'], 'string', 'max' => 70],
            [['text_short'], 'string', 'max' => 200],
            [['tags'], 'string', 'max' => 150],
            [['fk_status'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['fk_status' => 'id']],
            [['fk_user_create'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['fk_user_create' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'header' => 'Header',
            'alias' => 'Alias',
            'date_create' => 'Date Create',
            'date_publication' => 'Date Publication',
            'text_short' => 'Text Short',
            'text_full' => 'Text Full',
            'date_update_content' => 'Date Update Content',
            'tags' => 'Tags',
            'fk_status' => 'Fk Status',
            'fk_user_create' => 'Fk User Create',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['fk_content' => 'id']);
    }

    /**
     * Gets query for [[Contentandfotos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentandfotos()
    {
        return $this->hasMany(Contentandfoto::class, ['fk_content' => 'id']);
    }

    /**
     * Gets query for [[FkStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkStatus()
    {
        return $this->hasOne(Role::class, ['id' => 'fk_status']);
    }

    /**
     * Gets query for [[FkUserCreate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkUserCreate()
    {
        return $this->hasOne(Status::class, ['id' => 'fk_user_create']);
    }

    /**
     * Gets query for [[Views]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViews()
    {
        return $this->hasMany(View::class, ['fk_content' => 'id']);
    }
}
