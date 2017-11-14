<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\article;

use Yii;

class Module extends \yii\base\Module
{
    /**
     * @var string
     */
    public $defaultRoute = 'article';

    public function init()
    {
        parent::init();
        /**
         * 注册语言包
         */
        if (!isset(Yii::$app->i18n->translations['article*'])) {
            Yii::$app->i18n->translations['article*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }
}