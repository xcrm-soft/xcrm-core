<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Attribute\Base;

use XCrm\Data\Attribute\Attribute;
use XCrm\Database\Migration\MigrationOfConfigurable;

/**
 * Строковый атрибут
 *
 * @package XCrm\Data\Attribute\Base
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class StringAttribute extends Attribute
{
    public function coreRules()
    {
        return [
            $this->name . '-type' => [$this->name, 'string'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getMigrationDefinition(MigrationOfConfigurable $migration)
    {
        return $this->addDefinitions($migration->string($this->length));
    }
}