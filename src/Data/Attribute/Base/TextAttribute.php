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
use yii\widgets\ActiveField;

/**
 * Строковый атрибут
 *
 * @package XCrm\Data\Attribute\Base
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class TextAttribute extends Attribute
{
    public $enableEditor = false;
    public $rows = 5;

    public function coreRules()
    {
        return [
            $this->name . '-type' => [$this->name, 'string'],
        ];
    }

    public function formField(ActiveRecordConfigurable $model, ActiveField $field)
    {
        if ($this->enableEditor) {
            $field->widget('editor');
        } else {
            $field->textarea(['rows' => $this->rows]);
        }

    }

    /**
     * {@inheritDoc}
     */
    public function getMigrationDefinition(MigrationOfConfigurable $migration)
    {
        return $this->addDefinitions($migration->text());
    }
}