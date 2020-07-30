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
 * Первичный ключ.
 * Используется целочисленный беззныковый с автоинкрементом.
 * Не использует механизм addDefinitions(), так как формат ключа постоянный и должен совпадать
 * с форматом внешних ключей
 *
 * @package XCrm\Data\Attribute\Special
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class PrimaryKeyAttribute extends IntUnsignedAttribute
{
    public $length = 11;

    /**
     * {@inheritDoc}
     */
    public function getMigrationDefinition(MigrationOfConfigurable $migration)
    {
        return $migration->primaryKey($this->length)->unsigned();
    }
}