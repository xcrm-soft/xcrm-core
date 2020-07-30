<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Reference\Model;
use XCrm\Data\ActiveRecordConfigurable;
use XCrm\Modules\Reference\Model\ReferenceStructure;
use XCrm\Modules\Reference\Model\ReferenceBook;

/**
 * Реестр справочников
 *
 * @property int $id
 * @property int $parent_id
 * @property string $uuid
 * @property string|ReferenceBook $class_name
 * @property string $table_name
 * @property string $jacket_svg
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @package XCrm\Module\Reference\Model
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class ReferenceRegistry extends ActiveRecordConfigurable
{
    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return '{{%reference_models_registry}}';
    }

    /**
     * {@inheritDoc}
     */
    public static function hierarchy()
    {
        return [
            'parent' => ReferenceStructure::class,
        ];
    }

    public static function allowsCreate()
    {
        return false;
    }

    public static function allowsDelete()
    {
        return false;
    }
}