<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Website\Model;
use XCrm\Data\ActiveRecordConfigurable;

class PageLegalI18N extends ActiveRecordConfigurable
{
    public static function tableName()
    {
        return '{{%website_legal_i18n}}';
    }

    public static function hierarchy()
    {
        return [
            'master' => PageLegal::class,
        ];
    }
}