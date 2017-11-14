<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\article\backend;

class Module extends \yuncms\article\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'yuncms\article\backend\controllers';

    /**
     * @var string
     */
    public $defaultRoute = 'article';
}