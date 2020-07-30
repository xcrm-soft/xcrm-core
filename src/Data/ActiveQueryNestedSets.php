<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data;


use creocoder\nestedsets\NestedSetsQueryBehavior;

class ActiveQueryNestedSets extends ActiveQuery
{
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::class
        ];
    }
}