<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Attribute\Base;


use XCrm\Data\ActiveRecordConfigurable;
use yii\widgets\ActiveField;

class StringDropDownAttribute extends StringAttribute
{
    public $dropDownData;

    public function formField(ActiveRecordConfigurable $model, ActiveField $field)
    {
        $data = is_callable($this->dropDownData)
            ? call_user_func($this->dropDownData)
            : $this->dropDownData;
        $field->dropDownList($data);
    }
}