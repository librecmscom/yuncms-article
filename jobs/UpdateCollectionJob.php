<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\article\jobs;

use yii\base\BaseObject;
use yii\queue\Queue;
use yii\queue\RetryableJobInterface;
use yuncms\article\models\Article;

class UpdateCollectionJob extends BaseObject implements RetryableJobInterface
{
    public $id;

    /**
     * @param Queue $queue
     */
    public function execute($queue)
    {
        if (($model = Article::findOne(['id' => $this->id])) != null) {
            $model->updateCounters(['collections' => 1]);
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