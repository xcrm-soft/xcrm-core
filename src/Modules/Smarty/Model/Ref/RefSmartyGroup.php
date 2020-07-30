<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Smarty\Model\Ref;
use XCrm\Modules\Reference\Model\ReferenceBook;

class RefSmartyGroup extends ReferenceBook
{
    public static function getTitle()
    {
        return 'Группы шаблонов Smarty';
    }

    public static function tableName()
    {
        return '{{%xref_smarty_group}}';
    }
}