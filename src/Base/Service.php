<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Base;
use XCrm\Application\Base\Component;

/**
 * Class Service
 *
 * @property-read null|boolean $serviceStatus
 *
 * @package XCrm\Base
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
abstract class Service extends Component
{
    const STATUS_NONE    = null;
    const STATUS_FAIL    = false;
    const STATUS_SUCCESS = true;

    /**
     * Статус выполнения сервиса
     * @var null|boolean
     * @see getServiceStatus()
     */
    protected $_serviceStatus = self::STATUS_NONE;


    abstract public function run();

    /**
     * @return bool|null
     */
    public function getServiceStatus()
    {
        return $this->_serviceStatus;
    }
}