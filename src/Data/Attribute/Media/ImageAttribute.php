<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Attribute\Media;


use XCrm\Data\ActiveRecordConfigurable;
use XCrm\Database\Migration\MigrationOfConfigurable;
use XCrm\Media\CutterBehavior;
use XCrm\Media\ImageUploadBehavior;
use yii\widgets\ActiveField;

class ImageAttribute extends FileAttribute
{
    public function coreRules()
    {
        return [
            $this->name . '-type' => [$this->name, 'string'],
        ];
    }

    public function formField(ActiveRecordConfigurable $model, ActiveField $field)
    {
        $field->widget('image', []);
    }

    public function coreBehaviors()
    {
        return [
            $this->name . '-upload' => [
                'class' => ImageUploadBehavior::class,
                'attribute' => $this->name,
            ],
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