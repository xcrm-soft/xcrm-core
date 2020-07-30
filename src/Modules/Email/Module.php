<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Email;
use XCrm\I18N\I18NTrait;

class Module extends \XCrm\Application\Base\Module
{
    use I18NTrait;

    public static function i18nCategory()
    {
        return 'xcrm/modules/email';
    }
}