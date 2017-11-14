<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\article\jobs;

use Yii;
use yii\base\BaseObject;
use yii\queue\Queue;
use yii\queue\RetryableJob;
use yuncms\article\models\Article;

/**
 * 异步更新点击数
 * @package yuncms\article\jobs
 */
class UpdateViewsJob extends BaseObject implements RetryableJob
{
    public $id;

    /**
     * @param Queue $queue
     */
    public function execute($queue)
    {
        if (($model = Article::findOne(['id' => $this->id])) != null) {
            $model->updateCounters(['views' => 1]);
        }
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 60;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 3;
    }
}