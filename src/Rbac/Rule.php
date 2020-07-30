<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Rbac;
use XCrm\Application\ApplicationAwareTrait;

class Rule extends \yii\rbac\Rule
{
    use ApplicationAwareTrait;

    public function execute($user, $item, $params)
    {
        return true;
    }
}