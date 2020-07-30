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

class SmartyTemplateI18N extends ActiveRecordConfigurable
{
    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return '{{%smarty_template_i18n}}';
    }

    public static function hierarchy()
    {
        return [
            'master' => SmartyTemplate::class,
        ];
    }
}