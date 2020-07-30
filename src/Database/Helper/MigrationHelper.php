<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Database\Helper;


class MigrationHelper
{
    /**
     * @param $driverName
     * @return string|null
     */
    public static function resolveTableOptions($driverName)
    {
        if ('mysql' === $driverName) {
            return 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        return null;
    }
}