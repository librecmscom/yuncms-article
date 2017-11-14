<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\article\frontend;

class Module extends \yuncms\article\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'yuncms\article\frontend\controllers';

    /**
     * @var string
     */
    public $defaultRoute = 'article';
}