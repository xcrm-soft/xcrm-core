<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Application\Web;


class Session extends \yii\web\Session
{
    public function pop($key, $defaultValue = null)
    {
        $value = parent::get($key, $defaultValue);
        parent::remove($key);
        return $value;
    }
}