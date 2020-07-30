<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Reference\Model;
use XCrm\Data\ActiveRecordConfigurable;

class ReferenceStructure extends ActiveRecordConfigurable
{
    public static function tableName()
    {
        return '{{%reference_structure}}';
    }

    public static function allowsCreate()
    {
        return false;
    }

    public static function allowsDelete()
    {
        return false;
    }
}