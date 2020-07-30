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
use yii\db\ColumnSchemaBuilder;

/**
 * Целочисленный атоибут со знаком
 *
 * @package XCrm\Data\Attribute\Base
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class IntAttribute extends Attribute
{
    /**
     * @var bool признак наличия знака
     */
    public $unsigned = false;

    public function coreRules()
    {
        return [
            $this->name . '-type' => [$this->name, 'integer'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getMigrationDefinition(MigrationOfConfigurable $migration)
    {
        return $this->addDefinitions($migration->integer($this->length));
    }

    /**
     * {@inheritDoc}
     */
    public function addDefinitions(ColumnSchemaBuilder $definition)
    {
        if ($this->unsigned) $definition->unsigned();
        return parent::addDefinitions($definition);
    }
}