<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Attribute\Special;
use XCrm\Data\Attribute\Base\IntUnsignedAttribute;

class NestedSetsKeyAttribute extends IntUnsignedAttribute
{
    public function rules()
    {
        $rr = [];
        if (!empty($this->rules)) foreach ($this->rules as $k=>$v) {
            array_unshift($v, $this->name);
            $rr[$k] = $v;
        }
        $all = array_merge($this->coreRules(), $rr);

        return $all;
    }
}