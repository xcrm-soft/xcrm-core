<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Application\Base;


trait ComponentTrait
{
    /**
     * @param $value
     * @return mixed
     */
    public function resolveCallable($value)
    {
        if (is_callable($value)) {
            return $value($this);
        }
        return $value;
    }
}