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
use XCrm\Database\Migration\MigrationOfConfigurable;

/**
 * Внешний ключ
 * Не использует механизм addDefinitions(), т.к. должен бвто того же формата, что и первичный ключ.
 *
 * @package XCrm\Data\Attribute\Special
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class ForeignKeyAttribute extends IntUnsignedAttribute
{
    /**
     * {@inheritDoc}
     */
    public function getMigrationDefinition(MigrationOfConfigurable $migration)
    {
        return $migration->integer()->unsigned();
    }
}