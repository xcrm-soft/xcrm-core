<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Attribute\Base;
use XCrm\Data\ActiveRecordConfigurable;
use XCrm\Data\Attribute\Attribute;
use XCrm\Database\Migration\MigrationOfConfigurable;
use yii\db\ColumnSchemaBuilder;
use yii\widgets\ActiveField;

/**
 * Целочисленный атоибут со знаком
 *
 * @package XCrm\Data\Attribute\Base
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class BooleanAttribute extends Attribute
{
    public $defaultValue = 0;

    public function coreRules()
    {
        return [
            $this->name . '-type' => [$this->name, 'boolean'],
        ];
    }

    public function formField(ActiveRecordConfigurable $model, ActiveField $field)
    {
        $field->dropDownList([
            0 => 'выключено',
            1 => 'активно'
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getMigrationDefinition(MigrationOfConfigurable $migration)
    {
        return $this->addDefinitions($migration->integer(1)->notNull()->defaultValue($this->defaultValue ? 1 : 0));
    }
}