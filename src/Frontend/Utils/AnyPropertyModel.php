<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Frontend\Utils;
use yii\base\BaseObject;

/**
 * Модель-заглушка для передачи в представления вместо несуществующих моделей
 *
 * @property string content_short
 * @property string content_full
 *
 * @package XCrm\Frontend\Utils
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class AnyPropertyModel extends BaseObject
{
    private $_properties = [];

    public function __set($name, $value)
    {
        $this->_properties[$name] = $value;
    }

    public function __get($name)
    {
        return $this->_properties[$name] ?? null;
    }
}