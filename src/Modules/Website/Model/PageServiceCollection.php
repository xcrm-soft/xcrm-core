<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Website\Model;
use yii\base\BaseObject;

class PageServiceCollection extends BaseObject
{
    private $_blocks = [];

    public function __get($name)
    {
        if (isset($this->_blocks[$name])) {
            return $this->_blocks[$name];
        }
        return null;
    }

    public function __construct($config = [])
    {
        foreach ($config as $k=>$v) {
            if ($block = PageService::findOne(['key_name' => $v])) {
                $this->_blocks[$k] = $block->localize();
            }
        }

        parent::__construct([]);
    }
}