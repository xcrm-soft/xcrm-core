<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\I18N\Model\Ref;
use XCrm\Modules\Reference\Model\ReferenceBook;

class RefCategory extends ReferenceBook
{
    public static function getTitle()
    {
        return 'Категории сообщений';
    }

    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return '{{%xref_i18n_categories}}';
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