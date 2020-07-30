<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Application\Console;


class Session
{
    private $_params = [];
    private $_session = [];

    public function getHasSessionId()
    {
        return true;
    }

    public function generateID()
    {
        return 'console';
    }

    public function regenerateID()
    {
        return 'console';
    }

    public function __set($name, $value)
    {
        $this->_params[$name] = $value;
    }

    public function __get($name)
    {
        return $this->_params[$name] ?? null;
    }

    public function set($key, $value)
    {
        $this->_session[$key] = $value;
    }

    public function get($key, $defaultValue = null)
    {
        return $this->_session[$key] ?? $defaultValue;
    }

    public function remove()
    {
        $this->_session = [];
    }
}