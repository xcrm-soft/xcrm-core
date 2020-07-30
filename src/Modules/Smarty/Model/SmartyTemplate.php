<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Smarty\Model;
use XCrm\Data\ActiveRecordConfigurable;
use XCrm\Modules\Smarty\Model\Ref\RefSmartyCategory;
use XCrm\Modules\Smarty\Model\Ref\RefSmartyGroup;
use yii\base\NotSupportedException;

/**
 * Class SmartyTemplate
 *
 * @method SmartyTemplateI18N getLocalizationModel($language = null, $autofill = false)
 *
 * @property int $id
 * @property string $key_name
 * @property int $xref_refSmartyCategory
 * @property int $xref_refSmartyGroup
 * @property string $name
 * @property string $source_code
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property-read RefSmartyCategory $refSmartyCategory
 * @property-read RefSmartyGroup $refSmartyGroup
 *
 * @property-read string $fullName
 *
 * @package XCrm\Modules\Smarty\Model
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class SmartyTemplate extends ActiveRecordConfigurable
{
    public static function i18nCategory()
    {
        return 'xcrm/plugins/smarty';
    }

    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return '{{%smarty_template}}';
    }

    public static function hierarchy()
    {
        return [
            'i18n' => SmartyTemplateI18N::class,
        ];
    }

    /**
     * @return string
     * @throws NotSupportedException
     */
    public function getFullName()
    {
        if ($this->isNewRecord) throw new NotSupportedException('Full name is not allowed for new records');
        return $this->refSmartyCategory->keyName . '/' . $this->refSmartyGroup->keyName . '/' .  $this->key_name;
    }

}