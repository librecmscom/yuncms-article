<?php

namespace yuncms\article\models;

use Yii;

/**
 * This is the model class for index "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $sub_title
 * @property string $description
 * @property string $content
 * @property integer $category_id
 * @property integer $created_at
 */
class ArticleIndex extends \yii\sphinx\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function indexName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'unique'],
            [['id', 'category_id'], 'integer'],
            [['title', 'sub_title', 'description', 'content'], 'string'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('article', 'ID'),
            'title' => Yii::t('article', 'Title'),
            'sub_title' => Yii::t('article', 'Sub Title'),
            'description' => Yii::t('article', 'Description'),
            'content' => Yii::t('article', 'Content'),
            'category_id' => Yii::t('article', 'Category ID'),
            'created_at' => Yii::t('article', 'Created At'),
        ];
    }
}
