<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Database;
use XCrm\Application\ApplicationAwareTrait;
use XCrm\Database\Helper\MigrationHelper;

class Migration extends \yii\db\Migration
{
    use ApplicationAwareTrait;

    public function createTable($table, $columns, $options = null)
    {
        parent::createTable($table, $columns, $options ?? MigrationHelper::resolveTableOptions($this->getDb()->driverName));
    }
}