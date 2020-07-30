<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data;


use XCrm\Database\Connection;

class ActiveRecord extends \yii\db\ActiveRecord
{
    use ModelTrait;

    /**
     * @return Connection
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public static function getDb()
    {
        return parent::getDb();
    }

    public static function hasTableColumn($name)
    {
        return false;
    }

    public static function isSortable()
    {
        return false;
    }
}