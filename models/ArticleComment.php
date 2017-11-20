<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\article\models;

use Yii;
use yuncms\article\jobs\UpdateCommentJob;
use yuncms\comment\models\CommentQuery;

/**
 * Class Comment
 * @package yuncms\article\models
 */
class ArticleComment extends \yuncms\comment\models\Comment
{
    const TYPE = 'yuncms\article\models\Article';

    /**
     * @return void
     */
    public function init()
    {
        $this->model_class = self::TYPE;
        parent::init();
    }

    /**
     * @return CommentQuery
     */
    public static function find()
    {
        return new CommentQuery(get_called_class(), ['model_class' => self::TYPE, 'tableName' => self::tableName()]);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->model_class = self::TYPE;
        Yii::$app->queue->push(new UpdateCommentJob(['id' => $this->model_id]));
        return parent::beforeSave($insert);
    }
}