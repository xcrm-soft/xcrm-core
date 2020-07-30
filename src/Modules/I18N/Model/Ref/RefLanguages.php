<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\I18N\Model\Ref;
use XCrm\Modules\Reference\Model\ReferenceBook;

/**
 * Class RefLanguages
 *
 * @property int $is_primary
 * @property int $is_secondary
 * @property string $key_name
 * @property string $name
 *
 * @package XCrm\Module\I18N\Model\Ref
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class RefLanguages extends ReferenceBook
{
    public static function getTitle()
    {
        return 'Коды языков';
    }

    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return '{{%xref_i18n_languages}}';
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'is_primary' => 'Для интерфейсов',
            'is_secondary' => 'Для контента',
        ]);
    }
}