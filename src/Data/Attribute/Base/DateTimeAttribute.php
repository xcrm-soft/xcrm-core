<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Attribute\Base;
use XCrm\Database\Migration\MigrationOfConfigurable;

class DateTimeAttribute extends StringAttribute
{
    public function getMigrationDefinition(MigrationOfConfigurable $migration)
    {
        return $this->addDefinitions($migration->dateTime());
    }
}