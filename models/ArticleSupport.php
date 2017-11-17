<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\article\models;

use Yii;
use yuncms\article\jobs\UpdateSupportJob;
use yuncms\support\models\SupportQuery;

/**
 * Class Support
 * @package yuncms\article\models
 */
class ArticleSupport extends \yuncms\support\models\Support
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
     * @return SupportQuery
     */
    public static function find()
    {
        return new SupportQuery(get_called_class(), ['model_class' => self::TYPE, 'tableName' => self::tableName()]);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->model_class = self::TYPE;
        Yii::$app->queue->push(new UpdateSupportJob(['id' => $this->model_id]));
        return parent::beforeSave($insert);
    }
}