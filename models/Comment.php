<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\article\models;

use yuncms\comment\models\CommentQuery;

/**
 * Class Comment
 * @package yuncms\article\models
 */
class Comment extends \yuncms\comment\models\Comment
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
        return parent::beforeSave($insert);
    }
}